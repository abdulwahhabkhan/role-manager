<?php

namespace Mamikon\RoleManager\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;
use Mamikon\RoleManager\Models\Roles;

/**
 * Role Request Validation
 *
 * @category Laravel_Package
 * @package  Mamikon\RoleManager
 * @author   Mamikon Arakelyan <m.araqelyan@gmail.com>
 * @license  https://github.com/mamikon/role-manager/blob/master/LICENSE.md MIT
 * @link     https://github.com/mamikon/role-manager
 */
class RoleRequest extends FormRequest
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
            'description' => 'required|max:255',
            'name' => 'required|max:255|unique:' .
                config('roleManager.rolesTable') . ',name',
            'permission.*' => 'exists:' .
                config('roleManager.permissionsTable') . ',id'

        ];

        if (Request::isMethod('put')) {
            $role = Roles::where('id', Request::route('role'))->firstOrFail();
            if ($role->name == Request::input('name')) {
                $return['name'] = 'required|max:255';
            }
        }
        return $return;
    }
}
