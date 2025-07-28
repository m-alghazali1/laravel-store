<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;

class RoleController extends Controller
{
     public function __construct()
    {
        $this->authorizeResource(Role::class, 'role');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $roles = Role::withCount('permissions')->get();
        return response()->view('roles.index', ['roles' => $roles]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $guards = [
            ['name' => 'Admin', 'value' => 'admin'],
            ['name' => 'User', 'value' => 'user'],
        ];
        return response()->view('roles.create', ['guards' => $guards]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = validator($request->all(), [
            'name' => 'required|string',
            'guard' => 'required|string|in:admin,user',
        ]);
        if (!$validator->fails()) {
            $role = Role::create([
                'name' => $request->input('name'),
                'guard_name' => $request->input('guard'),
            ]);

            return response()->json(['status' => $role ? true : false, 'message' => $role ? 'Role created successfully' : 'Failed to create role']);

        } else {
            return response()->json(
                [
                    'status' => false,
                    'message' => $validator->getMessageBag()->first()
                ],
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        //
        $permissions = Permission::where('guard_name', '=', $role->guard_name)->get();
        $rolePermissions = $role->permissions;

        if ($rolePermissions->count()) {
            foreach ($permissions as $permission) {
                foreach ($rolePermissions as $userPermission) {
                    if ($permission->id === $userPermission->id) {
                        $permission->assigned = true; // ✅ تعيين الخاصية على العنصر نفسه
                    }
                }
            }
        }

        return response()->view('roles.role-permissions', ['role' => $role, 'permissions' => $permissions]);
    }

    public function updateRolePermission(Request $request)
    {
        $validator = Validator($request->all(), [
            'role_id' => 'required|numeric|exists:roles,id',
            'permission_id' => 'required|numeric|exists:permissions,id',
        ]);

        if (!$validator->fails()) {
            $permission = Permission::findOrFail($request->input('permission_id'));
            $role = Role::findOrFail($request->input('role_id'));

            $role->hasPermissionTo($permission)
                ? $role->revokePermissionTo($permission)
                : $role->givePermissionTo($permission);

            return response()->json(['status' => true, 'message' => 'Permission Updated']);
        } else {
            return response()->json(
                ['status' => false, 'message' => $validator->getMessageBag()->first()],
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $deletedCount = Role::destroy($id);
        return response()->json(['status' => true, 'message' => 'Deleted Successfully'], Response::HTTP_OK);
    }
}
