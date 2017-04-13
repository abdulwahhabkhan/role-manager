<?php

namespace Mamikon\RoleManager\Models;

use Illuminate\Database\Eloquent\Model;
/**
 * Permission Model
 *
 * @category Laravel_Package
 * @package  Mamikon\RoleManager
 * @author   Mamikon Arakelyan <m.araqelyan@gmail.com>
 * @license  https://github.com/mamikon/role-manager/blob/master/LICENSE.md MIT
 * @link     https://github.com/mamikon/role-manager
 */
class Permissions extends Model
{
    protected $fillable = ['name', 'description', 'class', 'method'];

    /**
     * Permissions constructor.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('roleManager.permissionsTable');

    }


    /**
     * Role relation setting
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Roles::class);
    }
}
