<?php

namespace Database\Factories;

use App\Models\Documento;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Documento>
 */
class DocumentoFactory extends Factory
{
    protected $model = Documento::class;

    public function definition(): array
    {
        $tipo = $this->faker->randomElement(['pdf', 'epub']);

        return [
            'titulo' => $this->faker->sentence(3),
            'tipo' => $tipo,
            'ruta_archivo' => 'documentos/'.$this->faker->uuid().'.'.$tipo,
            'user_id' => User::factory(),
        ];
    }

    public function pdf(): self
    {
        return $this->state(fn () => ['tipo' => 'pdf']);
    }

    public function epub(): self
    {
        return $this->state(fn () => ['tipo' => 'epub']);
    }
}
