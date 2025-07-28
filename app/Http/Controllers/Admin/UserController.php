<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function index()
    {
        $users = User::withCount(['orders', 'permissions'])->get();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }
    public function store(Request $request)
    {
        $validator = validator($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|confirmed|min:6'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Created Account failed'
            ]);
        }

        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->assignRole('Customer');

        $save = $user->save();
        return response()->json([
            'status' => $save,
            'message' => 'Created Account Successfully'
        ]);

    }
    public function edit(User $user)
    {
        return view('admin.users.edit', ['user' => $user]);
    }
    public function update(Request $request, User $user)
    {
        $validator = Validator($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->getMessageBag()->first()
            ], Response::HTTP_BAD_REQUEST);
        }

        $user->name = $request->input('name');
        $user->email = $request->input('email');

        $saved = $user->save();

        return response()->json([
            'status' => $saved,
            'message' => $saved ? 'Updated successfully' : 'Update failed'
        ], $saved ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }

    public function editUserPermissions(Request $request, User $user)
    {
        $permissions = Permission::where('guard_name', 'user')->get();
        $userPermissions = $user->permissions;

        if (count($userPermissions) > 0) {
            foreach ($userPermissions as $uPermission) {
                foreach ($permissions as $permission) {
                    if ($permission->id == $uPermission->id) {
                        $permission->setAttribute('assigned', true);
                    }
                }
            }
        }
        return response()->view('admin.users.user-permissions', ['permissions' => $permissions, 'user' => $user]);
    }
    public function updateUserPermissions(Request $request, User $user)
    {
        $validator = Validator($request->all(), [
            'permission_id' => 'required|numeric|exists:permissions,id',
        ]);
        if (!$validator->fails()) {
            $permission = Permission::findById($request->input('permission_id'), 'user');
            $result = $user->hasPermissionTo($permission)
                ? $user->revokePermissionTo($permission)
                : $user->givePermissionTo($permission);

            return response()->json([
                'status' => $result,
                'message' => $result ? 'Permission updated successfully' : 'Failed to update permission',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => $validator->getMessageBag()->first(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

    }

    public function show($id)
    {
        $user = User::with('orders')->findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'تم حذف المستخدم');
    }
}
