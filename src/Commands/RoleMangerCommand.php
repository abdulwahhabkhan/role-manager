<?php

namespace Mamikon\RoleManager\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Auth\User;
use Mamikon\RoleManager\Models\Permissions;
use Mamikon\RoleManager\Models\Roles;

class RoleMangerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permissions:migrate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get Permissions And Roles from config, and add to db';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     *
     * @throws \Exception
     */
    public function handle()
    {
        $permissions = config('roleManager.permissions');
        $roles = config('roleManager.roles');
        foreach ($permissions as $permissionName => $permission) {

            $permissionModel = new Permissions();
            if (empty($permissionName)) {
                throw new \Exception('Permission Name Required');
            }

            if (!$permissionModel->where('name', $permissionName)->first()) {


                $permissionModel->name = $permissionName;

                if (isset($permission['description'])) {
                    $permissionModel->description = $permission['description'];
                }
                if (isset($permission['class'])) {
                    $permissionModel->class = $permission['class'];
                }
                if (isset($permission['method'])) {
                    $permissionModel->method = $permission['method'];
                }
                $permissionModel->save();
            }

        }
        foreach ($roles as $roleName => $role) {
            $roleModel = new Roles();
            if (empty($roleName)) {
                throw new \Exception('Role Name Required');
            }
            if (!$roleModel->where('name', $roleName)->first()) {
                $roleModel->name = $roleName;
                if (isset($role['description'])) {
                    $roleModel->description = $role['description'];
                }
                $roleModel->save();
            }
        }

        $defaultRoles = config('roleManager.assignPermissionsToRole');
        foreach ($defaultRoles as $roleName => $permissionsList) {

            $roleModel = Roles::where('name', $roleName)
                ->with('permissions')->first();
            if ($roleModel) {

                if ($permissionsList == '*') {
                    foreach ($permissions as $permissionName => $permission) {
                        $permissionModel = Permissions::
                                        where('name', $permissionName)
                                        ->first();
                        if ($permissionModel) {
                            $checker = $roleModel->permissions
                                ->where('name', $permissionName)->first();
                            if (!$checker) {
                                $roleModel->permissions()->attach($permissionModel);
                            }
                        }
                    }

                } elseif (is_array($permissionsList)) {
                    foreach ($permissions as $permissionName) {

                        $permissionModel = Permissions::
                            where('name', $permissionName)->first();

                        if ($permissionModel) {

                            $checker = $roleModel->
                            permissions->where('name', $permissionName)->first();

                            if (!$checker) {
                                $roleModel->permissions()->attach($permissionModel);
                            }
                        }
                    }
                }
            }
        }

        $userAssignments = config('roleManager.assignRoleToUser');
        if (!empty($userAssignments) AND is_array($userAssignments)) {
            foreach ($userAssignments as $roleName => $userEmail) {
                $roleModel = Roles::where('name', $roleName)->first();
                if ($user = User::where('email', $userEmail)->first()
                    AND $roleModel
                    AND !$roleModel->belongsToUser($user)
                ) {
                    $roleModel->users()->attach($user);
                }
            }
        }
        echo "All permission Migrated Successfully";
    }
}
