<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cart = CartItem::with('product')
            ->where('user_id', auth()->id())
            ->get();
        return response()->json([
            'status' => true,
            'message' => 'Cart fetched successfully',
            'data' => $cart
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
            'product_id' => 'required|exists:products,id'
        ]);

        $cartItem = CartItem::where('user_id', auth()->id())
            ->where('product_id', $validated['product_id'])
            ->first();
        if ($cartItem) {
            $cartItem->quantity +=  $validated['quantity'];
            $cartItem->save();
        } else{
            CartItem::Create([
                'user_id' => auth()->id(),
                'product_id' => $validated['product_id'],
                'quantity' => $validated['quantity']
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Product added to cart!'
        ], Response::HTTP_CREATED);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = CartItem::where('id', $id)->where('user_id', auth()->id())
            ->first();

        if (!$cart) {
            return response()->json([
                'status' => false,
                'message' => 'Cart item not found.'
            ], Response::HTTP_NOT_FOUND);
        }

        $cart->update([
            'quantity' => $validated['quantity']
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Cart updated!',
            'data' => $cart
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $cartItem = CartItem::where('user_id', auth()->id())
            ->where('id', $id)
            ->first();

        if (!$cartItem) {
            return response()->json([
                'status' => false,
                'message' => 'Cart item not found'
            ], ٌResponse::HTTP_NOT_FOUND);
        }

        $deleted = $cartItem->delete();

        return response()->json([
            'status' => $deleted,
            'message' => $deleted ? 'Product Deleted from cart!' : 'Product not deleted!'
        ], $deleted ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);;
    }

}
