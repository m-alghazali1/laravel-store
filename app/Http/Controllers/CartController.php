<?php
namespace App\Http\Controllers;

use App\Models\CartItem;
use Illuminate\Http\Request;
use App\Models\Product;
use Symfony\Component\HttpFoundation\Response;

class CartController extends Controller
{
    public function index()
    {
        $cart = CartItem::with('product')
            ->where('user_id', auth()->id())
            ->get();
        $moreProduct = Product::inRandomOrder()->limit(8)->get();
        return view('cart', compact('cart', 'moreProduct'));
    }

    public function store(Request $request, $product_id)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::find($product_id);
        if (!$product) {
            return response()->json([
                'status' => false,
                'message' => 'Product not found.'
            ], Response::HTTP_NOT_FOUND);
        }

        $cartItem = CartItem::where('user_id', auth()->id())
            ->where('product_id', $product_id)
            ->first();
        if ($cartItem) {
            $cartItem->quantity +=  $validated['quantity'];
            $cartItem->save();
        } else{
            CartItem::create([
                'user_id' => auth()->id(),
                'product_id' => $product_id,
                'quantity' => $validated['quantity']
            ]);
        }
            return response()->json([
                'status' => true,
                'message' => 'Product added to cart!',
            ], Response::HTTP_ACCEPTED);
    }

    public function update(Request $request, $cart_id)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cartItem = CartItem::where('id', $cart_id)
            ->where('user_id', auth()->id())
            ->first();

        if (!$cartItem) {
            return back()->with('error', 'Cart item not found.');
        }

        $cartItem->update([
            'quantity' => $validated['quantity']
        ]);

        return back()->with('success', 'Cart updated!');
    }


    public function destroy(CartItem $cart)
    {
        if ($cart->user->id !== auth()->id()) {
            abort(403);
        }

        $cart->delete();
        return back()->with('message', 'Product removed!');

    }
}
