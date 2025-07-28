<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateAdminRequest;
use App\Models\Admin;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Admin::class, 'admin');
    }

    public function index()
    {
        $admins = Admin::with('roles')->get();
        return response()->view('admin.index', ['admins' => $admins]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::where('guard_name', 'admin')->get();
        return view('admin.create', ['roles' => $roles]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = validator($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id',
        ]);

        if (!$validator->fails()) {
            $admin = new Admin();
            $admin->name = $request->input('name');
            $admin->email = $request->input('email');
            $admin->password = Hash::make($request->input('password'));
            $saved = $admin->save();

            if ($saved) {
                $role = Role::find($request->input('role_id')); // تأكد find() أو first()
                if ($role) {
                    $admin->assignRole($role->name);
                }
            }

            return response()->json(
                [
                    'status' => $saved,
                    'message' => $saved ? 'Created successfully' : 'Created Failed'
                ],
                $saved ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST
            );

        } else {
            return response()->json(
                [
                    'error' => $validator->getMessageBag()->first()
                ],
                Response::HTTP_BAD_REQUEST
            );
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Admin $admin)
    {
        $user = auth(session('guard'))->user();
        $guard = session('guard');

        if ($guard === 'admin') {
            return response()->view('admin.show', ['admin' => $admin]);
        } elseif ($guard === 'vendor') {
            return response()->view('admin.show', ['vendor' => $admin]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized access'
            ], Response::HTTP_FORBIDDEN);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Admin $admin)
    {
        $roles = Role::where('guard_name', 'admin')->get();
        $role = $admin->roles()->first();
        return view('admin.edit', ['roles' => $roles, 'curent_role' => $role, 'admin' => $admin]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Admin $admin)
    {
        $validator = validator($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $admin->id,
            'role_id' => 'required|exists:roles,id',
        ]);



        if (!$validator->fails()) {
            $admin->name = $request->input('name');
            $admin->email = $request->input('email');
            $saved = $admin->save();
            if ($saved) {
                $role = Role::find($request->input('role_id'));
                if ($role) {
                    $admin->syncRoles($role->name);
                }
            }
            return response()->json(
                [
                    'status' => $saved,
                    'message' => $saved ? 'Updated successfully' : 'Updated Failed'
                ],
                $saved ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST
            );

        } else {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Updated Failed'
                ],
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admin $admin)
    {
        $status = $admin->delete();

        if (!$status) {
            return response()->json([
                'icon' => 'error',
                'message' => 'Failed to delete admin',
            ], Response::HTTP_BAD_REQUEST);
        } else {
            return response()->json([
                'icon' => 'success',
                'message' => 'Admin deleted successfully',
            ], Response::HTTP_OK);
        }

    }
}
