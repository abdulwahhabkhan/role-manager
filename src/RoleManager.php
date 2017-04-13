<?php

namespace Mamikon\RoleManager;


use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Mamikon\RoleManager\Models\Permissions;
use Mamikon\RoleManager\Models\Roles;

/**
 * Class RoleManager
 *
 * @category Laravel_Package
 * @package  Mamikon\RoleManager
 * @author   Mamikon Arakelyan <m.araqelyan@gmail.com>
 * @license  https://github.com/mamikon/role-manager/blob/master/LICENSE.md MIT
 * @link     https://github.com/mamikon/role-manager
 */
class RoleManager
{
    /**
     * Define all permission and make usable from laravel application
     *
     * @return bool
     */
    public function defineAllPermissions()
    {
        foreach ($this->getPermissions() as $permission) {

            Gate::define(
                $permission->name,
                function ($user, ...$arguments) use ($permission) {
                    foreach ($permission->roles as $role) {
                        if ($role->belongsToUser($user)) {
                            if (!empty($permission->class)
                                AND !empty($permission->method)
                                AND class_exists($permission->class)
                            ) {
                                $container = resolve($permission->class);
                                if (method_exists($container, $permission->method)) {
                                    array_unshift($arguments, $user);
                                    return
                                        call_user_func_array(
                                            [$container, $permission->method],
                                            $arguments
                                        );
                                } else {
                                    return false;
                                }
                            }
                            return true;
                        }
                    }
                    return false;
                }
            );
        }
        return false;
    }

    /**
     * Assign Role to user
     *
     * @param int|User         $user User Instance or user id
     * @param int|string|Roles $role Role Instance, role name, or role id
     *
     * @return bool
     */
    public function assignRole($user, $role)
    {
        if (is_int($user) and !$user = User::where('id', $user)->first()) {
            return false;
        }
        if (is_int($role) and !$role = Roles::where('id', $role)->first()) {
            return false;
        }
        if (is_string($role) and !$role = Roles::where('name', $role)->first()) {
            return false;
        }
        if (!($user instanceof User) or !($role instanceof Roles)) {
            return false;
        }
        return $role->assignToUser($user);
    }

    /**
     * Remove Role from user
     *
     * @param int|User         $user User Instance or user id
     * @param int|string|Roles $role Role Instance, role name, or role id
     *
     * @return bool
     */
    public function removeRole($user, $role)
    {
        if (is_int($user) and !$user = User::where('id', $user)->first()) {
            return false;
        }
        if (is_int($role) and !$role = Roles::where('id', $role)->first()) {
            return false;
        }
        if (is_string($role) and !$role = Roles::where('name', $role)->first()) {
            return false;
        }
        if (!($user instanceof User) or !($role instanceof Roles)) {
            return false;
        }
        $role->users()->detach($user->id);
        return true;
    }

    /**
     * Get All permissions
     *
     * @return array|\Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getPermissions()
    {
        if (Schema::hasTable(config('roleManager.permissionsTable'))) {
            return Permissions::with('roles')->get();
        }
        return [];
    }

}