<?php


namespace Mamikon\RoleManager\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Mamikon\RoleManager\Models\Roles;
use Mamikon\RoleManager\Requests\UserRolesRequest;

/**
 * Class RoleManagerController
 *
 * @category Laravel_Package
 * @package  Mamikon\RoleManager
 * @author   Mamikon Arakelyan <m.araqelyan@gmail.com>
 * @license  https://github.com/mamikon/role-manager/blob/master/LICENSE.md MIT
 * @link     https://github.com/mamikon/role-manager
 */
class RoleManagerController extends Controller
{
    /**
     * List All users
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $this->authorize('view_users');

        if (!empty($request->term)) {
            $term = trim($request->term);
            $users = User::where('email', 'like', '%' . $term . '%')
                ->orWhere('name', 'like', '%' . $term . '%')
                ->paginate(config('roleManager.usersPerPage'));
        } else {
            $users = User::paginate(config('roleManager.usersPerPage'));
        }
        return view('RoleManager::index', ['users' => $users]);
    }

    /**
     * View User Role Management Form
     *
     * @param int $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $this->authorize('manage_user_roles');
        $user = User::where('id', $id)->firstOrFail();
        $roles = Roles::all();
        $valueList = array();
        if (!empty($roles)) {
            foreach ($roles as $role) {
                if ($role->belongsToUser($user)) {
                    $valueList[] = $role->id;
                }
            }
        }
        return view(
            'RoleManager::edit',
            ['user' => $user, 'roles' => Roles::all(), 'valueList' => $valueList]
        );
    }

    /**
     * Store changes
     *
     * @param UserRolesRequest $request
     * @param int $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function update(UserRolesRequest $request, $id)
    {
        $this->authorize('manage_user_roles');
        $user = User::where('id', $id)->firstOrFail();
        $roles = Roles::with('users')->get();
        if (!empty($roles)) {
            foreach ($roles as $role) {
                if (!empty($request->role)
                    AND $role->users->where('id', $id)->count() === 0
                    AND is_array($request->role)
                    AND in_array($role->id, $request->role)
                ) {
                    $role->users()->attach($id);
                } elseif ((is_array($request->role)
                    AND !in_array($role->id, $request->role))
                ) {
                    $role->users()->detach($id);
                } elseif (empty($request->role)) {
                    $role->users()->detach();
                }
            }
        }
        $request->session()->flash('message', 'User Roles Successfully updated');
        return redirect()->route('RoleManager::viewUserRole', $id);
    }
}
