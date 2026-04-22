<?php

namespace App\Providers;

use App\Models\Documento;
use App\Policies\DocumentoPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Documento::class => DocumentoPolicy::class,
    ];

    public function boot(): void
    {
        //
    }
}
