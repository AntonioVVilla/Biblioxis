<?php

use App\Models\Documento;
use App\Models\User;

test('guests are redirected from dashboard', function () {
    $this->get(route('dashboard'))->assertRedirect(route('login'));
});

test('dashboard shows aggregated stats for the current user only', function () {
    $user = User::factory()->create();
    $other = User::factory()->create();

    Documento::factory()->pdf()->count(3)->for($user)->create();
    Documento::factory()->epub()->count(2)->for($user)->create();
    Documento::factory()->pdf()->count(5)->for($other)->create();

    $response = $this->actingAs($user)->get(route('dashboard'));

    $response->assertOk();
    expect($response->viewData('totalDocumentos'))->toBe(5)
        ->and($response->viewData('totalPdfs'))->toBe(3)
        ->and($response->viewData('totalEpubs'))->toBe(2)
        ->and($response->viewData('documentosRecientes'))->toHaveCount(5);
});

test('dashboard handles users with no documents', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get(route('dashboard'));

    $response->assertOk();
    expect($response->viewData('totalDocumentos'))->toBe(0)
        ->and($response->viewData('totalPdfs'))->toBe(0)
        ->and($response->viewData('totalEpubs'))->toBe(0);
});

test('health endpoint responds with ok', function () {
    $this->get(route('health'))
        ->assertOk()
        ->assertJsonStructure(['status', 'time'])
        ->assertJsonFragment(['status' => 'ok']);
});
