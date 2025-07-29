<?php

namespace App\Policies;

use App\Models\User;
use App\Models\RefJenisGtk;
use Illuminate\Auth\Access\HandlesAuthorization;

class RefJenisGtkPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_ref::jenis::gtk');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, RefJenisGtk $refJenisGtk): bool
    {
        return $user->can('view_ref::jenis::gtk');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_ref::jenis::gtk');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, RefJenisGtk $refJenisGtk): bool
    {
        return $user->can('update_ref::jenis::gtk');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, RefJenisGtk $refJenisGtk): bool
    {
        return $user->can('delete_ref::jenis::gtk');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_ref::jenis::gtk');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, RefJenisGtk $refJenisGtk): bool
    {
        return $user->can('force_delete_ref::jenis::gtk');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_ref::jenis::gtk');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, RefJenisGtk $refJenisGtk): bool
    {
        return $user->can('restore_ref::jenis::gtk');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_ref::jenis::gtk');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, RefJenisGtk $refJenisGtk): bool
    {
        return $user->can('replicate_ref::jenis::gtk');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder_ref::jenis::gtk');
    }
}
