<?php

namespace App\Http\Controllers\Backend;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Role;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use App\Models\Permission;
use Illuminate\Support\Facades\Request as FRequest;

class RoleController extends Controller
{

    public function index()
    {
        $search = request('search');

        return Inertia::render('Backend/Acl/Roles/Index',[
            'filters' => FRequest::only(['search']),
            'roles' => Role::when(FRequest::input(['search']), function ($query, $search) {
                    $query->where('name', 'like', "%{$search}%");
                })
                ->orderBy('guard_name')
                ->orderBy('name')
                ->paginate(request('rowsPerPage', 10))
                ->withQueryString()
                ->through(fn ($role) => [
                    'id' => $role->uuid,
                    'name' => $role->name,
                    //'guard_name' => $role->guard_name,
                    'permissions' => $role->permissions->map->only('name','uuid'),
                ]) ?? null,
        ]);


            // $role = Role::with(['permissions' => function ($q) {
            //     $q->get(['id', 'name']);
            // },
            // ])->findOrFail($id);

            // $role->permissions->map(function ($permission) {
            //     unset($permission->pivot);

            //
                //return $permission;
            // });

            // $permissions = Permission::orderBy('name')->get(['id', 'name']);
    }

    public function create()
    {
        return Inertia::render('Backend/Acl/Roles/Create');
    }

    public function store(RoleRequest $request)
    {
        // Retrieve the validated input data...
        //If it's valid, it will proceed. If it's not valid, throws a ValidationException.
        $validatedData = $request->validated();

        Role::create($validatedData);

        return to_route('admin.roles.index')->with('status','Role Created Successfully');
    }

    public function edit(Role $role)
    {
        return Inertia::render('Backend/Acl/Roles/Edit', [
            'role' => [
                'id' => $role->uuid,
                'name' => $role->name
            ]
        ]);
    }

    public function update(RoleRequest $request, Role $role)
    {

        // Authorize to update
        $this->authorize('update', $role);

        // Retrieve the validated input data...
        //If it's valid, it will proceed. If it's not valid, throws a ValidationException.
        $validatedData = $request->validated();

        $role->update($validatedData);

        return to_route('admin.roles.index')->with('status','Role Updated Successfully');
    }

    public function destroy(Role $role)
    {
        // Authorize to delete
        $this->authorize('delete', $role);

        Log::info('Role:');
        Log::info($role);


        Log::info('Role permissions are:');
        Log::info($role->permissions);

        if ($role->permission != null) {

            return back()
                ->withError('A permission is linked to this role. You must first delete the permission!')
                ->withInput();
        }
        else if($role->name == 'Super Admin') {
            Log::info("Role name is: {$role->name}");

            return back()
                ->withError('This role cannot be deleted!')
                ->withInput();
        }
        else {
            $role->delete();
        }

        return redirect()->back()->with('success', 'Role Deleted Successfully');
    }

    public function addPermissionToRole($roleId)
    {
        $permissions = Permission::get();
        $role = Role::findOrFail($roleId);
        $rolePermissions = DB::table('role_has_permissions')
                                ->where('role_has_permissions.role_id', $role->id)
                                ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
                                ->all();

        return view('role-permission.role.add-permissions', [
            'role' => $role,
            'permissions' => $permissions,
            'rolePermissions' => $rolePermissions
        ]);
    }

    public function givePermissionToRole(Request $request, $roleId)
    {
        $request->validate([
            'permission' => 'required'
        ]);

        $role = Role::findOrFail($roleId);
        $role->syncPermissions($request->permission);

        return redirect()->back()->with('status','Permissions added to role');
    }
}
