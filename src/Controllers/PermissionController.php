<?php

namespace Mamikon\RoleManager\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mamikon\RoleManager\Models\Permissions;
use Mamikon\RoleManager\Requests\PermissionRequest;

/**
 * Resource Class for Permissions
 *
 * @category Laravel_Package
 * @package  Mamikon\RoleManager
 * @author   Mamikon Arakelyan <m.araqelyan@gmail.com>
 * @license  https://github.com/mamikon/role-manager/blob/master/LICENSE.md MIT
 * @link     https://github.com/mamikon/role-manager
 */

class PermissionController extends Controller
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
        $this->authorize('view_permission');
        if (!empty($request->term)) {
            $term = trim($request->term);
            $permissions = Permissions::where('name', 'like', '%' . $term . '%')
                ->orWhere('description', 'like', '%' . $term . '%')
                ->orWhere('class', 'like', '%' . $term . '%')
                ->orWhere('method', 'like', '%' . $term . '%')
                ->paginate(config('roleManager.permissionsPerPage'));

        } else {
            $permissions = Permissions::paginate(
                config('roleManager.permissionsPerPage')
            );

        }
        return view(
            "RoleManager::permission.index",
            ['permissions' => $permissions]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create_permission');
        return view('RoleManager::permission.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request|PermissionRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(PermissionRequest $request)
    {
        $this->authorize('create_permission');
        $permission = Permissions::create($request->all());
        $request->session()->flash('message', 'Permission Successfully Created');
        return redirect()->route('RoleManager::permission.edit', $permission->id);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param int|Permissions $permission
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Permissions $permission)
    {
        $this->authorize('edit_permission');
        return view('RoleManager::permission.edit', ['permission' => $permission]);
    }

    /**
     * Update the permission in storage.
     *
     * @param Request|PermissionRequest $request
     * @param int                       $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(PermissionRequest $request, $id)
    {
        $this->authorize('edit_permission');
        $permission = Permissions::where('id', $id)->firstOrFail();
        $permission->update($request->all());
        $request->session()->flash('message', 'Permission Updated Successfully');
        return redirect()->route('RoleManager::permission.edit', $permission->id);
    }

    /**
     * Remove the permission from storage.
     *
     * @param int $id Permission Id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete_permission');
        Permissions::where('id', $id)->delete();
        session()->flash('message', 'Permission Deleted Successfully');
        session()->flash('message-status', 'alert-info');
        return redirect()->route('RoleManager::permission.index');
    }
}
