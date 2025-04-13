<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

use App\Models\Documento;
use App\Policies\DocumentoPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Las policy mappings para la aplicación.
     *
     * @var array<class-string, class-string>
     */
    protected \$policies = [
        Documento::class => DocumentoPolicy::class,
    ];

    /**
     * Registrar cualquier servicio de autenticación/autorización.
     */
    public function boot(): void
    {
        //
    }
}
