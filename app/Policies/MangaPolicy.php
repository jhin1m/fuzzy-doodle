<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Manga;
use Illuminate\Auth\Access\Response;

class MangaPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_mangas');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Manga $manga): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_mangas');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Manga $manga): bool
    {
        return ($user->id === $manga->user_id && $user->can('edit_own_mangas')) || $user->can('edit_all_mangas');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Manga $manga): bool
    {
        return ($user->id === $manga->user_id && $user->can('delete_own_mangas')) || $user->can('delete_all_mangas');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Manga $manga): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Manga $manga): bool
    {
        //
    }
}
