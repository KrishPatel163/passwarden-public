<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UsersPassword;
use Illuminate\Auth\Access\Response;

class UsersPasswordPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user) 
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, UsersPassword $usersPassword) 
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user) 
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, UsersPassword $usersPassword) 
    {
        //
        return $user->id === $usersPassword->users_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, UsersPassword $usersPassword) 
    {
        //
        return $user->id === $usersPassword->users_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, UsersPassword $usersPassword) 
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, UsersPassword $usersPassword) 
    {
        //
    }
}