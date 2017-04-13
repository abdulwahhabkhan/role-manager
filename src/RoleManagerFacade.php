<?php

namespace Mamikon\RoleManager;
use Illuminate\Support\Facades\Facade;

/**
 * @method static bool assignRole(mixed $user, mixed $role)
 * @method static bool removeRole(mixed $user, mixed $role)
 *
 * @see \Mamikon\RoleManager\RoleManager
 */
class RoleManagerFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Mamikon\RoleManager';
    }
}