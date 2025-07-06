<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
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
        return response()->view('home', ['products' => $products, 'categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
        $product = Product::with(['category', 'images'])->findOrFail($id);
        $moreProduct = Product::inRandomOrder()->take(4)->get();

        return view('productsShow', [
            'product' => $product,
            'moreProduct' => $moreProduct
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
        $products = Product::where('category_id', $id)->with('images')->get();

        return view('home', compact('products'));
    }

    public function search(Request $request)
    {
        $products = Product::where('name', 'like', '%' . $request->search . '%')->with('images')->get();
        return response()->json($products);
    }

}
