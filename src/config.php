<?php
/**
 * Configuration File for RoleManager package
 *
 */
return [
    /*
    |----------------------------------------------------------------
    | Default List of Permissions and roles
    |----------------------------------------------------------------
    |
    | After publishing package You can add others there
    | it will be helpful when you want initialise/reinitialise
    | your project in other place.
    |
    | All you need after that run command
    | php artisan permissions:migrate
    */

    'permissions' => [
        'create_permission' => [
            'description' => "Create Permissions",
        ],
        'delete_permission' => [
            'description' => "Delete Permissions",
        ],
        'view_permission' => [
            'description' => "View Permissions",
        ],
        'edit_permission' => [
            'description' => "Edit Permission",
        ],
        'create_role' => [
            'description' => "Create Role",
        ],
        'delete_role' => [
            'description' => "Delete Role",

        ],
        'view_role' => [
            'description' => "view Roles",
        ],
        'edit_role' => [
            'description' => "Edit Role",
        ],
        'view_users' => [
            'description' => "View Users List",
        ],
        'manage_user_roles' => [
            'description' => "Manage User Roles",
        ],
    ],

    'roles' => [
        'super-admin' => [
            'description' => "Can Do everything",
        ]
    ],

    'assignPermissionsToRole' => [
        //Assign all permissions to supper admin
        //if you want not all permissions you can give it via array
        'super-admin' => '*'
    ],
    'assignRoleToUser' => [
        'super-admin' => 'admin@pass.com',
    ],


    /*
    |----------------------------------------------------------------
    | Permissions Table Name
    |----------------------------------------------------------------
    */
    'permissionsTable' => env('ROLE_MANAGER_PERMISSIONS_TABLE', 'permissions'),

    /*
    |----------------------------------------------------------------
    | Role Table Name
    |----------------------------------------------------------------
    */
    'rolesTable' => env('ROLE_MANAGER_ROLES_TABLE', 'roles'),

    /*
    |----------------------------------------------------------------
    | Extended view
    |----------------------------------------------------------------
    |
    | View name that will be extended.
    | if you don't want extend any view use as argument false
    |
    */
    'extendedView' => env('ROLE_MANAGER_EXTENDED_VIEW', 'layouts.app'),

    /*
    |----------------------------------------------------------------
    | Extended section
    |----------------------------------------------------------------
    |
    | Extended section Name.
    | if you use value false,
    | view not be extended even you define it at extendsView config
    |
    */
    'extendedSection' => env('ROLE_MANAGER_EXTENDED_SECTION', 'content'),

    /*
    |----------------------------------------------------------------
    | Load Bootstrap Externally
    |----------------------------------------------------------------
    |
    | default view designed using bootstrap,
    | if you don't use bootstrap but want use default views
    | you can load bootstrap externally
    |
    */
    'externalBootstrap' => env('ROLE_MANAGER_EXTERNAL_BOOTSTRAP', false),
    /*
    |----------------------------------------------------------------
    | Load Jquery Externally
    |----------------------------------------------------------------
    |
    | default view designed using jquery,
    | if you don't use jquery but want use default views
    | you can load jquery externally
    |
    */
    'externalJquery' => env('ROLE_MANAGER_EXTERNAL_JQUERY', false),
    /*
    |----------------------------------------------------------------
    | Route Prefix
    |----------------------------------------------------------------
    */
    'routePrefix' => env('ROUTE_PREFIX', '/role-manager'),

    /*
    |----------------------------------------------------------------
    | Per Page Items
    |----------------------------------------------------------------
    */
    'usersPerPage' => env('USERS_PER_PAGE', 15),
    'permissionsPerPage' => env('PERMISSIONS_PER_PAGE', 15),
    'rolesPerPage' => env('ROLES_PER_PAGE', 15),
];