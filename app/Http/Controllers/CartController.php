<?php
namespace App\Http\Controllers;

use App\Models\CartItem;
use Illuminate\Http\Request;
use App\Models\Product;

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
//        dd($request);
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

        return back()->with('message', 'Product added to cart!');

    }

    public function update(Request $request, CartItem $cart)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        if ($cart->user_id !== auth()->id()) {
            abort(403);
        }

        $cart->update([
            'quantity' => $validated['quantity']
        ]);
        return back()->with('message', 'Cart updated!');
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
