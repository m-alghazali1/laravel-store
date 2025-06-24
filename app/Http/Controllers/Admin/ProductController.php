<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Log;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Controller;
use function Laravel\Prompts\alert;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('category', 'images')->get();
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', ['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
            'oldPrice' => 'nullable|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1',
            'category_id' => 'required|exists:categories,id',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120'
        ]);
        $product = new Product();
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->old_price = $request->input('oldPrice', null);
        $product->price = $request->input('price');
        $product->quantity = $request->input('quantity');
        $product->category_id = $request->input('category_id');
        $isSaved = $product->save();

        if ($isSaved && $request->hasFile('images')) {
            foreach ($request->file('images') as $imageFile) {
                $fileName = uniqid() . '_' . time() . '.' . $imageFile->getClientOriginalExtension();
                $imagePath = $imageFile->storeAs('products', $fileName, 'public');

                $product_images = new ProductImage();
                $product_images->image_url = $imagePath;
                $product_images->product_id = $product->id;
                $product_images->save();
            }
        }

        return response()->json([
            'status' => $isSaved,
            'message' => $isSaved ? "Saved Successfully" : "Save failed",
        ], $isSaved ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
        // return response()->json([
        //     'message' => $isSaved ? 'Product Created Successfully' : 'Product Created failed',
        //     'product' => $product
        // ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::with(['category', 'images'])->findOrFail($id);
        $moreProduct = Product::inRandomOrder()->take(4)->get();

        return view('admin.products.show', [
            'product' => $product,
            'moreProduct' => $moreProduct
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::with('category')->findOrFail($id);
        $categories = Category::all();
        return view('admin.products.edit', ['product' => $product, 'categories' => $categories]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1',
            'category_id' => 'required|exists:categories,id',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $product = Product::findOrFail($id);

        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->quantity = $request->input('quantity');
        $product->category_id = $request->input('category_id');

        $isSaved = $product->save();

        if ($isSaved) {
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {

                    $fileName = uniqid() . '_' . time() . '.' . $image->getClientOriginalExtension();
                    $path = $image->storeAs('products', $fileName, 'public');

                    $product->images()->create([
                        'image_url' => $path
                    ]);
                }
            }
            return response()->json(['message' => 'Product saved successfully']);
        } else {
            return response()->json(['message' => 'Product save failed!'], 500);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $deleted = Product::findOrFail($id)->delete();
        return response()->json([
            "status" => $deleted,
            "message" => $deleted ? "Deleted Successfully" : "Delete Failed",
            "icon" => $deleted ? "success" : "Error",
        ]);
    }

    public function trash()
    {
        $products = Product::onlyTrashed()->get();
        return view('admin.products.trash', compact('products'));
    }

    public function forceDelete(string $id)
    {
        $deleted = Product::onlyTrashed()->findOrFail($id)->forceDelete();
        return response()->json([
            "status" => "$deleted",
            "message" => $deleted ? "Deleted Successfully" : "Delete Failed",
            "icon" => $deleted ? "success" : "Error",
        ]);
    }


    public function restore($id)
    {
        $products = Product::onlyTrashed()->findOrFail($id);
        $restored = $products->restore();

        return response()->json([
            'status' => $restored,
            'message' => $restored ? 'Restored successfully!' : 'Restore failed!',
            'icon' => $restored ? 'success' : 'error'
        ]);
    }

    public function deleteImage($id)
    {
        $image = ProductImage::findOrFail($id);

        if (Storage::disk('public')->exists($image->image_url)) {
            Storage::disk('public')->delete($image->image_url);
        }

        $deleted = $image->delete();
        if ($deleted) {
            return response()->json([
                'status' => true,
                'message' => 'Image deleted successfully'
            ]);

        } else {
            return response()->json([
                'status' => false,
                'message' => 'Failed to delete image'
            ], 500);
        }

        // return redirect()->back()->with([
        //     'message' => $deleted ? 'Image deleted successfully' : 'Failed to delete image',
        //     'status' => $deleted,
        // ]);
    }
}
