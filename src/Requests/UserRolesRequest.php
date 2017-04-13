<?php

namespace Mamikon\RoleManager\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Mamikon\RoleManager\Models\Permissions;

/**
 * User-Role assignment validation
 *
 * @category Laravel_Package
 * @package  Mamikon\RoleManager
 * @author   Mamikon Arakelyan <m.araqelyan@gmail.com>
 * @license  https://github.com/mamikon/role-manager/blob/master/LICENSE.md MIT
 * @link     https://github.com/mamikon/role-manager
 */
class UserRolesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $return = [
            'role.*'=>'exists:'.config('roleManager.rolesTable').',id'
        ];
        return $return;
    }
}
