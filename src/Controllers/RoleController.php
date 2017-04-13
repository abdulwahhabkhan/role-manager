<?php

namespace Mamikon\RoleManager\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mamikon\RoleManager\Models\Permissions;
use Mamikon\RoleManager\Models\Roles;
use Mamikon\RoleManager\Requests\RoleRequest;

/**
 * Class RoleController
 *
 * @category Laravel_Package
 * @package  Mamikon\RoleManager
 * @author   Mamikon Arakelyan <m.araqelyan@gmail.com>
 * @license  https://github.com/mamikon/role-manager/blob/master/LICENSE.md MIT
 * @link     https://github.com/mamikon/role-manager
 */
class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view_role');
        if (!empty($request->term)) {
            $term = trim($request->term);
            $roles = Roles::where('name', 'like', '%' . $term . '%')
                ->orWhere('description', 'like', '%' . $term . '%')
                ->paginate(config('roleManager.rolesPerPage'));

        } else {
            $roles = Roles::paginate(config('roleManager.rolesPerPage'));
        }
        return view('RoleManager::role.index', ['roles' => $roles]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create_role');

        return view(
            'RoleManager::role.create',
            ['permissions' => Permissions::all()]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request|RoleRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    {
        $this->authorize('create_role');

        $role = Roles::create($request->all());
        if (!empty($request->permission) AND is_array($request->permission)) {
            foreach ($request->permission as $permission) {
                $role->permissions()->attach($permission);
            }
        }
        $request->session()->flash('message', 'Role Successfully Created');
        return redirect()->route('RoleManager::role.edit', $role->id);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param Roles $role
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Roles $role)
    {
        $this->authorize('edit_role');

        $valueList = $role->permissions()->get()->pluck('id')->toArray();
        return view(
            'RoleManager::role.edit',
            ['role' => $role, 'permissions' => Permissions::all(),
                'valueList' => $valueList]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request|RoleRequest $request
     * @param int                 $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(RoleRequest $request, $id)
    {
        $this->authorize('edit_role');

        $role = Roles::where('id', $id)->firstOrFail();
        $role->update($request->all());
        if (!empty($request->permission) AND is_array($request->permission)) {
            $role->permissions()->sync($request->permission);

        } else {
            $role->permissions()->detach();
        }
        $request->session()->flash('message', 'Role Updated Successfully');
        return redirect()->route('RoleManager::role.edit', $role->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete_role');

        Roles::where('id', $id)->delete();
        session()->flash('message', 'Role Deleted Successfully');
        session()->flash('message-status', 'alert-info');
        return redirect()->route('RoleManager::role.index');
    }
}
