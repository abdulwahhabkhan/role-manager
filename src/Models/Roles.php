<?php

namespace Mamikon\RoleManager\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;
/**
 * Role model
 *
 * @category Laravel_Package
 * @package  Mamikon\RoleManager
 * @author   Mamikon Arakelyan <m.araqelyan@gmail.com>
 * @license  https://github.com/mamikon/role-manager/blob/master/LICENSE.md MIT
 * @link     https://github.com/mamikon/role-manager
 */
class Roles extends Model
{
    protected $fillable = ['name', 'description'];

    /**
     * Roles constructor.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('roleManager.rolesTable');
    }


    /**
     * Permission Relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany(Permissions::class);
    }

    /**
     * Users relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * Check if user has role
     *
     * @param User $user
     *
     * @return bool
     */
    public function belongsToUser(User $user)
    {
        return !!$this->users()->where('user_id', $user->id)->count();
    }

    /**
     * Assign Role to User
     *
     * @param User $user
     *
     * @return bool
     */
    public function assignToUser(User $user)
    {
        if ($this->belongsToUser($user)) {
            return true;
        }
        $this->users()->attach($user->id);
        return true;
    }
}
