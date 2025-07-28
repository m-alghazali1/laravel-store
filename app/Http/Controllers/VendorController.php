<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use App\Http\Requests\StoreVendorRequest;
use App\Http\Requests\UpdateVendorRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct(){
        $this->authorizeResource(Vendor::class, 'vendor');
    }

    public function index()
    {
        $vendors = Vendor::with('roles')->get();
        return response()->view('admin.vendors.index', ['vendors' => $vendors]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.vendors.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    try {
        $validator = validator($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:vendors,email',
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'error' => $validator->getMessageBag()->first()
            ], 400);
        }

        $vendor = new Vendor();
        $vendor->name = $request->input('name');
        $vendor->email = $request->input('email');
        $vendor->phone = $request->input('phone');
        $vendor->address = $request->input('address');
        $vendor->password = Hash::make($request->input('password'));
        $vendor->status = 'pending';

        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
            $vendor->logo = $logoPath;
        }
        $saved = $vendor->save();

        if ($saved) {
            $vendor->assignRole('Store Owner');
        }

        return response()->json([
            'status' => true,
            'message' => 'Created successfully'
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Server error occurred',
            'error' => $e->getMessage()
        ], 500);
    }
}


    /**
     * Display the specified resource.
     */
    public function show(Vendor $vendor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vendor $vendor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVendorRequest $request, Vendor $vendor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vendor $vendor)
    {
        //
    }
}
