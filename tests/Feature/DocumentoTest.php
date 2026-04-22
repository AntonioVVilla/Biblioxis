<?php

use App\Models\Documento;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    Storage::fake('private');
});

test('unauthenticated users cannot see documento index', function () {
    $this->get(route('documentos.index'))->assertRedirect(route('login'));
});

test('authenticated users see their own documentos', function () {
    $user = User::factory()->create();
    $other = User::factory()->create();

    Documento::factory()->count(3)->for($user)->create();
    Documento::factory()->count(2)->for($other)->create();

    $response = $this->actingAs($user)->get(route('documentos.index'));

    $response->assertOk();
    expect($response->viewData('documentos')->total())->toBe(3);
});

test('users can upload a valid pdf', function () {
    $user = User::factory()->create();
    $file = UploadedFile::fake()->create('book.pdf', 100, 'application/pdf');

    $response = $this->actingAs($user)->post(route('documentos.store'), [
        'titulo' => 'Mi libro',
        'tipo' => 'pdf',
        'archivo' => $file,
    ]);

    $response->assertRedirect(route('documentos.index'));
    $response->assertSessionHas('success');

    $documento = Documento::firstWhere('user_id', $user->id);
    expect($documento)->not->toBeNull()
        ->and($documento->titulo)->toBe('Mi libro')
        ->and($documento->tipo)->toBe('pdf');

    Storage::disk('private')->assertExists($documento->ruta_archivo);
});

test('mismatched extension and tipo fails validation', function () {
    $user = User::factory()->create();
    $file = UploadedFile::fake()->create('book.epub', 100, 'application/epub+zip');

    $response = $this->actingAs($user)->post(route('documentos.store'), [
        'titulo' => 'Mismatched',
        'tipo' => 'pdf',
        'archivo' => $file,
    ]);

    $response->assertSessionHasErrors('archivo');
    expect(Documento::count())->toBe(0);
});

test('oversized files are rejected', function () {
    $user = User::factory()->create();
    $file = UploadedFile::fake()->create('huge.pdf', 30 * 1024, 'application/pdf');

    $response = $this->actingAs($user)->post(route('documentos.store'), [
        'titulo' => 'Huge',
        'tipo' => 'pdf',
        'archivo' => $file,
    ]);

    $response->assertSessionHasErrors('archivo');
});

test('users cannot view other users documentos', function () {
    $owner = User::factory()->create();
    $intruder = User::factory()->create();

    $documento = Documento::factory()->for($owner)->create();

    $this->actingAs($intruder)
        ->get(route('documentos.show', $documento))
        ->assertForbidden();
});

test('users can delete their own documento and the file is removed', function () {
    $user = User::factory()->create();
    $file = UploadedFile::fake()->create('book.pdf', 100, 'application/pdf');

    $this->actingAs($user)->post(route('documentos.store'), [
        'titulo' => 'A eliminar',
        'tipo' => 'pdf',
        'archivo' => $file,
    ]);

    $documento = Documento::firstWhere('user_id', $user->id);
    $ruta = $documento->ruta_archivo;

    Storage::disk('private')->assertExists($ruta);

    $this->actingAs($user)
        ->delete(route('documentos.destroy', $documento))
        ->assertRedirect(route('documentos.index'));

    expect(Documento::find($documento->id))->toBeNull();
    Storage::disk('private')->assertMissing($ruta);
});

test('users cannot delete another users documento', function () {
    $owner = User::factory()->create();
    $intruder = User::factory()->create();

    $documento = Documento::factory()->for($owner)->create();

    $this->actingAs($intruder)
        ->delete(route('documentos.destroy', $documento))
        ->assertForbidden();

    expect(Documento::find($documento->id))->not->toBeNull();
});

test('show returns 404 when the physical file is missing', function () {
    $user = User::factory()->create();
    $documento = Documento::factory()->for($user)->create([
        'ruta_archivo' => 'documentos/missing.pdf',
    ]);

    $this->actingAs($user)
        ->get(route('documentos.show', $documento))
        ->assertNotFound();
});
