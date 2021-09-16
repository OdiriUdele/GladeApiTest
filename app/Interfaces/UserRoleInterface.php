<?php

namespace App\Interfaces;


interface UserRoleInterface
{
    /**
     * Assign the given role to the user.
     *
     * @param  string $role
     * @return mixed
     */
    public function assignRole($role);

    /**
     * Determine if the user has any given role.
     *
     * @param  mixed $role
     * @return boolean
     */
    public function hasAnyRole($roles);

    /**
     * Determine if the entity has the given role.
     *
     * @param  mixed $role
     * @return boolean
     */
    public function hasRole($role);
}
