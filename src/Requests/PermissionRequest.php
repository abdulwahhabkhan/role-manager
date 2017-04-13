<?php

namespace Mamikon\RoleManager\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Mamikon\RoleManager\Models\Permissions;
/**
 * Permission request validation
 *
 * @category Laravel_Package
 * @package  Mamikon\RoleManager
 * @author   Mamikon Arakelyan <m.araqelyan@gmail.com>
 * @license  https://github.com/mamikon/role-manager/blob/master/LICENSE.md MIT
 * @link     https://github.com/mamikon/role-manager
 */
class PermissionRequest extends FormRequest
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
                config('roleManager.permissionsTable') . ',name',
            'class' => 'classExist',
            'method' => 'required_with:class|methodExist'

        ];

        if (Request::isMethod('put')) {
            $permission = Permissions::where(
                'id', Request::route('permission')
            )->firstOrFail();
            if ($permission->name == Request::input('name')) {
                $return['name'] = 'required|max:255';
            }

        }
        return $return;
    }
}
