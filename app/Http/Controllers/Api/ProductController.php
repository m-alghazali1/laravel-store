<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('category', 'images')->get();
        $categories = Category::all();

        return response()->json([
            'status' => true,
            'message' => 'Products fetched successfully',
            'products' => $products,
            'categories' => $categories,
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::with(['category', 'images'])->find($id);
        if (!$product) {
            return response()->json([
                'status' => false,
                'message' => 'Sorry, product with id ' . $id . ' cannot be found'
            ], Response::HTTP_NOT_FOUND);
        }

        $moreProduct = Product::inRandomOrder()->take(4)->get();

        return response()->json([
            'status' => true,
            'product' => $product,
            'moreProduct' => $moreProduct
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function categoryProducts($id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json([
                'status' => false,
                'message' => 'Category not found'
            ], Response::HTTP_NOT_FOUND);
        }

        $products = Product::where('category_id', $id)->with('images')->get();

        if ($products->isEmpty()){
            return response()->json([
                'status' => true,
                'message' => 'No products found for this category'
            ], Response::HTTP_OK);
        }
        return response()->json([
            'status' => true,
            'message' => 'Products found for this category',
            'data' => $products
        ], Response::HTTP_OK);
    }
}
