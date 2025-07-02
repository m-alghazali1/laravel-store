<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use Storage;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('category', 'images')->get();
        return response()->json([
            'status' => true,
            'message' => 'Products fetched successfully',
            'data' => $products
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
            'old_price' => 'nullable|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1',
            'category_id' => 'required|exists:categories,id',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120'
        ]);
        $product = new Product();
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->old_price = $request->input('old_price', null);
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
            'status' => true,
            'message' => 'Product created successfully',
            'product' => $product->load('images')
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::with(['category', 'images'])->find($id);
        $moreProduct = Product::inRandomOrder()->take(4)->get();

        if (!$product) {
            return response()->json([
                'status' => false,
                'message' => 'Sorry, product with id ' . $id . ' cannot be found'
            ], Response::HTTP_NOT_FOUND);
        }
        return response()->json([
            'status' => true,
            'message' => 'Product fetched successfully',
            'product' => $product,
            'moreProduct' => $moreProduct
        ], Response::HTTP_OK);
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

        $product = Product::find($id);

        if (!$product){
            return response()->json([
                'status' => false,
                'message' => 'Sorry, product with id ' . $id . ' cannot be found'
            ], Response::HTTP_NOT_FOUND);
        }

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
            return response()->json([
                'status' => true,
                'message' => 'Product saved successfully'
            ], Response::HTTP_OK);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Product save failed!'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::with('images')->find($id);
        if (!$product){
            return response()->json([
                'status' => false,
                'message' => 'Sorry, product with id ' . $id . ' cannot be found'
            ], Response::HTTP_NOT_FOUND);
        }
        $deleted = $product->delete();

        return response()->json([
            "status" => $deleted,
            "message" => $deleted ? "Deleted Successfully" : "Delete Failed"
        ], $deleted ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);;
    }


    public function trash()
    {
        $products = Product::onlyTrashed()->get();
        return response()->json([
            'status' => true,
            'message' => 'Deleted products fetched successfully',
            'data' => $products
        ], Response::HTTP_OK);
    }

    public function forceDelete(string $id)
    {
        $product = Product::onlyTrashed()->find($id);
        if (!$product){
            return response()->json([
                'status' => false,
                'message' => 'Sorry, product with id ' . $id . ' cannot be found'
            ], Response::HTTP_NOT_FOUND);
        }
        $deleted = false;
        if ($product->images && count($product->images) > 0) {
            foreach ($product->images as $image) {
                Storage::disk('public')->delete($image->image_url);
                $image->delete();
            }
        }
        $deleted = $product->forceDelete();
        return response()->json([
            'status' => $deleted,
            'message' => $deleted ? 'Deleted Successfully' : 'Delete Failed'
        ], $deleted ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }


    public function restore($id)
    {
        $products = Product::onlyTrashed()->find($id);
        if (!$products){
            return response()->json([
                'status' => false,
                'message' => 'Sorry, product with id ' . $id . ' cannot be found'
            ], Response::HTTP_NOT_FOUND);
        }
        $restored = $products->restore();

        return response()->json([
            'status' => $restored,
            'message' => $restored ? 'Restored successfully!' : 'Restore failed!'
        ], $restored ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }

    public function deleteImage($id)
    {
        $image = ProductImage::find($id);
        if (!$image){
            return response()->json([
                'status' => false,
                'message' => 'Sorry, image with id ' . $id . ' cannot be found'
            ], Response::HTTP_NOT_FOUND);
        }

        if (Storage::disk('public')->exists($image->image_url)) {
            Storage::disk('public')->delete($image->image_url);
        }

        $deleted = $image->delete();
        if ($deleted) {
            return response()->json([
                'status' => true,
                'message' => 'Image deleted successfully'
            ], Response::HTTP_OK);

        } else {
            return response()->json([
                'status' => false,
                'message' => 'Failed to delete image'
            ], Response::HTTP_BAD_REQUEST);
        }

    }
}
