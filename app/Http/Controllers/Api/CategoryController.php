<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::with(['products'])->get();

        return response()->json([
            'status' => true,
            'message' => 'Categories fetched successfully',
            'data' => $categories
        ], Response::HTTP_OK);
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

        return response()->json([
            'status' => $isSaved,
            'message' => $isSaved ? 'Category Created Successfully' : 'Category Created failed'
        ], $isSaved ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::with('products')->find($id);

        if(!$category){
            return response()->json([
                'status' => false,
                'message' => 'Not Found'
            ], Response::HTTP_NOT_FOUND);;
        }

        return response()->json([
            'status' => true,
            'message' => 'Category fetched successfully',
            'data' => $category
        ], Response::HTTP_OK);;
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
        $category = Category::find($id);
        if (!$category){
            return response()->json([
                'status' => false,
                'message' => "Category not found",
            ], Response::HTTP_NOT_FOUND);
        }

        $category->name = $request->input('name');
        $category->description = $request->input('description');
        $isSaved = $category->save();

        return response()->json([
            'status' => $isSaved,
            'message' => $isSaved ? 'Category Created Successfully' : 'Category Created failed',
            'data' => $category
        ], $isSaved ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::find($id);
        if (!$category){
            return response()->json([
                'status' => false,
                'message' => "Category not found",
            ], Response::HTTP_NOT_FOUND);
        }


        $deleted = $category->delete();

        if (!$deleted) {
            return response()->json([
                'status' => false,
                'message' => "Delete Failed",
            ], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([
            'status' => true,
            'message' => "Category deleted successfully",
        ], Response::HTTP_OK);
    }
}
