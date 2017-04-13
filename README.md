# RoleManager

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

Role and permission management system for laravel. This package impalement Role Management in Laravel. And you can create in easy way new permissions and assign them to the roles.


## Install

Via Composer

``` bash
$ composer require mamikon/role-manager
```
Then  add the ServiceProvider to the providers array in `config/app.php`.

```php

Mamikon\RoleManager\RoleManagerProvider::class,

```

You can use the facade for shorter code. Add this to your aliases:

```php

'RoleManager' => Mamikon\RoleManager\RoleManagerFacade::class,
```

To publish the config settings  use:

```bash

 $ php artisan vendor:publish --provider="Mamikon\RoleManager\RoleManagerProvider"

```

It will publish default views for Role and permission management and `roleManager.php` config file.

Before starting lets go over config file and make some configurations.

Config file contain default permissions, roles.

It will create some permissions for RoleManager package, after publishing package you can add
some new permissions right there and it will be more preferable than from admin panel, 
it will make your application more easy shippable.
Each permission must contain array key, it will be name of permission, and value of that key must be an array which contain description.
in addition of this you can add  class and method that will make additional checking for that permission

```php
'edit_post' => [
    'description' => "Edit Post",
    'class' => App\Permissions\Post::class, // not required
    'method' => 'canEdit', // not required
],
```

Then You can create default roles. Each array element must contain key which will be role name, and value- that will be description of our role

```php
'super-admin' =>  "Can Do everything",
```

Then You can assign some permissions to roles.

```php
'assignPermissionsToRole'=> [
    'editor' => [
            'edit_post',
            'publish_post',
            //...
        ]
 ],
```

You can use asterisk for add all permissions to that role
 
 ```php
'assignPermissionsToRole'=> [
    'super-admin' => '*'
 ],
```

Then you can add roles to users

```php
'assignRoleToUser' => [
    'super-admin'=>'admin@pass.com',
    'editor'=>'editor@pass.com',
 ],
```

All this configurations will be loaded after run artisan command `permission:migrate`

```bash
$ php artisan permissions:migrate
```

But before that we must migrate our tables. It by default will create 
4 tables
* permissions
* roles
* roles_user
* permissions_roles

If in your database exist tables permissions, and roles you can change their names from 
config file and then migrate
```php
    'permissionsTable'=>'other_permissions',
    'rolesTable'=>'other_roles',
```

RoleManager package will create routes for Role management control pages 
* /
* /role(resource)
* /permission(resource)
* /user/{id}

And they will be prefixed by default with `role-manager`.

```php
'routePrefix'=>'role-manager',
```

By default views will be extend form `layouts.app`

```php
'extendedView'=>'layouts.app',
```
If you don't want extend any view you can give value `false`
And You must give section where must be extended

```php

 'extendedSection'=>'content',

```

All configurations except default roles, permissions and default assignments can be loaded from `.env`

```
ROLE_MANAGER_PERMISSIONS_TABLE=permissions
ROLE_MANAGER_ROLES_TABLE=roles
ROLE_MANAGER_EXTENDED_VIEW=layout.app
ROLE_MANAGER_EXTENDED_SECTION=content
ROLE_MANAGER_EXTERNAL_BOOTSTRAP=false
ROLE_MANAGER_EXTERNAL_JQUERY=false
ROLE_MANAGER_ROUTE_PREFIX=role-manager
USERS_PER_PAGE=15
PERMISSIONS_PER_PAGE=15
ROLES_PER_PAGE=15
```
After all configuration will done run migration
```php
$ php aritsan migrate
```

And then 
```php
$ php aritsan permissions:migrate
```

## Usage
RoleManager don't change any logic in laravel authorization. 
You can use standard laravel facades, methods and functions.
```php
if (Gate::allows('update-post', $post)) {
    // The current user can update the post...
}

if (Gate::denies('update-post', $post)) {
    // The current user can't update the post...
}
```

In addition RoleManager facade has 2 helper functions 
* `RoleManager::assignRole(mixed $user, mixed $role)`
* `RoleManager::removeRole(mixed $user, mixed $role)`

As $user parameter can be User Model, or user_id(int)
As $role parameter can be Role Model, role_id(int), or role name(string)


## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

## Security

If you discover any security related issues, please email m.araqelyan@gmail.com instead of using the issue tracker.

## Credits

- [Mamikon Arakelyan][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/mamikon/role-manager.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/mamikon/role-manager/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/mamikon/role-manager.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/mamikon/role-manager.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/mamikon/role-manager.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/mamikon/role-manager
[link-travis]: https://travis-ci.org/mamikon/role-manager
[link-scrutinizer]: https://scrutinizer-ci.com/g/mamikon/role-manager/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/mamikon/role-manager
[link-downloads]: https://packagist.org/packages/mamikon/role-manager
[link-author]: https://github.com/mamikon
[link-contributors]: ../../contributors
