<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Category::class, 'category');
    }
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

        return redirect()->back()->with(
            [
                'status' => $isSaved,
                'message' => $isSaved ? "Category saved successfuly" : "Category save failed!"
            ]
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::with('products')->find($id);

        if (!$category) {
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
    public function edit(Category $category)
    {
        $category = Category::findOrFail($category->id);
        return view('admin.categories.edit', ['data' => $category]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:5',
            'description' => 'nullable|string'
        ]);
        $category = Category::findOrFail($category->id);
        $category->name = $request->input('name');
        $category->description = $request->input('description');
        $isSaved = $category->save();

        if (!$isSaved) {
            return response()->json([
                'icon' => 'error',
                'message' => 'Category Update Failed'
            ], Response::HTTP_BAD_REQUEST);
        } else {
            return response()->json([
                'icon' => 'success',
                'message' => 'Category Updated Successfully',
            ], Response::HTTP_OK);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $deleted = $category->delete();

        if (!$deleted) {
            return response()->json([
                'icon' => 'error',
                'message' => 'Failed to delete category',
            ], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([
            'icon' => 'success',
            'message' => 'Category deleted successfully',
        ], Response::HTTP_OK);
    }
}
