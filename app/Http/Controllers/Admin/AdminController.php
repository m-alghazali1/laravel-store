<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $admin = Admin::where('id', '=', auth('admin')->user()->id)->first();
        return response()->view('admin.index', compact('admin'));
    }
}
