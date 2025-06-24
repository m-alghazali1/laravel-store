<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::with(['products'])->get();
        return view('admin.categories.category', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:5',
            'description' => 'required|string'
        ]);

        $category = new Category();
        $category->name = $request->input('name');
        $category->description = $request->input('description');
        $isSaved = $category->save();

        return redirect()->back()->with([
            'status' => $isSaved,
            'message' => $isSaved ? "Category saved successfuly" : "Category save failed!"]
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::with('products')->find($id);

        if(!$category){
            return response()->json([
                'message' => 'Not Found'
            ], 404);
        }

        return response()->json([
            'category' => $category
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:5',
            'description' => 'nullable|string'
        ]);

        $category = Category::findOrFail($id);
        $category->name = $request->input('name');
        $category->description = $request->input('description');
        $isSaved = $category->save();

        return response()->json([
            'message' => $isSaved ? 'Category Created Successfully' : 'Category Created failed',
            'category' => $category
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $deleted = Category::findOrFail($id);
        $deleted->delete();
        return redirect()->back()->with([
            "status" => $deleted,
            "message" => $deleted ? "Deleted Successfully" : "Delete Failed",
        ]);
    }
}
