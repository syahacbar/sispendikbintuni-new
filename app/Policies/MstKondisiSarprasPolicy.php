<?php

namespace App\Policies;

use App\Models\User;
use App\Models\MstKondisiSarpras;
use Illuminate\Auth\Access\HandlesAuthorization;

class MstKondisiSarprasPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_mst::kondisi::sarpras');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, MstKondisiSarpras $mstKondisiSarpras): bool
    {
        return $user->can('view_mst::kondisi::sarpras');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_mst::kondisi::sarpras');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, MstKondisiSarpras $mstKondisiSarpras): bool
    {
        return $user->can('update_mst::kondisi::sarpras');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, MstKondisiSarpras $mstKondisiSarpras): bool
    {
        return $user->can('delete_mst::kondisi::sarpras');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_mst::kondisi::sarpras');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, MstKondisiSarpras $mstKondisiSarpras): bool
    {
        return $user->can('force_delete_mst::kondisi::sarpras');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_mst::kondisi::sarpras');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, MstKondisiSarpras $mstKondisiSarpras): bool
    {
        return $user->can('restore_mst::kondisi::sarpras');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_mst::kondisi::sarpras');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, MstKondisiSarpras $mstKondisiSarpras): bool
    {
        return $user->can('replicate_mst::kondisi::sarpras');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder_mst::kondisi::sarpras');
    }
}
