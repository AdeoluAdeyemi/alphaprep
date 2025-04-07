<?php


namespace App\Http\Controllers\Backend;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Role;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Support\Facades\Request as FRequest;

class RolePermissionController extends Controller
{
    public function edit($id)
    {
        $role = Role::with(['permissions' => function ($q) {
            $q->get(['uuid', 'name']);
        },
        ])->findOrFail($id);

        $role->permissions->map(function ($permission) {
            unset($permission->pivot);

            return $permission;
        });

        $permissions = Permission::orderBy('name')->get(['uuid', 'name']);
        Log::info('Role Name');
        Log::info($role->name);

        return inertia('Backend/Acl/RolePermission/Index', [
            'role' => $role,
            'permissions' => $permissions,
        ]);
    }

    public function update(Permission $permission, Request $request)
    {
        $role = Role::findOrFail($id);

        $role->syncPermissions(request('rolePermissions'));

        return redirect()->route('aclRole.index')
            ->with('success', 'Role permissions updated');
    }
}
