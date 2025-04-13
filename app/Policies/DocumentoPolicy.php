<?php

namespace App\Policies;

use App\Models\Documento;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DocumentoPolicy
{
    use HandlesAuthorization;

    /**
     * Determina si el usuario puede ver el documento.
     */
    public function view(User $user, Documento $documento): bool
    {
        return $user->id === $documento->user_id;
    }

    /**
     * Determina si el usuario puede crear un nuevo documento.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determina si el usuario puede actualizar el documento.
     */
    public function update(User $user, Documento $documento): bool
    {
        return $user->id === $documento->user_id;
    }

    /**
     * Determina si el usuario puede eliminar el documento.
     */
    public function delete(User $user, Documento $documento): bool
    {
        return $user->id === $documento->user_id;
    }
}
