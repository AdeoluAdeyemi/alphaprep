<?php

namespace App\Http\Controllers\Backend;

use Inertia\Inertia;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\PermissionRequest;
use Illuminate\Support\Facades\Request as FRequest;

class PermissionController extends Controller
{

    public function index()
    {
        $search = request('search');

        return Inertia::render('Backend/Acl/Permissions/Index',[
            'filters' => FRequest::only(['search']),
            'permissions' => Permission::when(FRequest::input(['search']), function ($query, $search) {
                    $query->where('name', 'like', "%{$search}%");
                })
                ->orderBy('guard_name')
                ->orderBy('name')
                ->paginate(request('rowsPerPage', 10))
                ->withQueryString()
                ->through(fn ($permission) => [
                    'id' => $permission->uuid,
                    'name' => $permission->name,
                    'guard' => $permission->guard,
                ]) ?? null,
        ]);
    }

    public function create()
    {
        return Inertia::render('Backend/Acl/Permissions/Create');
    }

    public function store(PermissionRequest $request)
    {
        // Retrieve the validated input data...
        //If it's valid, it will proceed. If it's not valid, throws a ValidationException.
        $validatedData = $request->validated();

        Permission::create($validatedData);

        return to_route('admin.permissions.index')->with('success','Permission Created Successfully');
    }

    public function edit(Permission $permission)
    {
        return Inertia::render('Backend/Acl/Permissions/Edit', [
            'permission' => [
                'id' => $permission->uuid,
                'name' => $permission->name
            ]
        ]);
    }

    public function update(PermissionRequest $request, Permission $permission)
    {
        // Authorize to update
        $this->authorize('update', $permission);

        // Retrieve the validated input data...
        //If it's valid, it will proceed. If it's not valid, throws a ValidationException.
        $validatedData = $request->validated();

        $permission->update($validatedData);

        return to_route('admin.permissions.index')->with('status','Permission Updated Successfully');
    }

    public function destroy(Permission $permission)
    {
        // Authorize to delete
        $this->authorize('delete', $permission);

        $permission = Permission::find($permission);
        $permission->delete();
        return redirect()->back()->with('success', 'Permission Deleted Successfully');
    }
}
