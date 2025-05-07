<?php

namespace App\Http\Controllers;

use App\Models\Parfum as Product;
use App\Models\CartItems as CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class CartController extends Controller
{
    public function view()
    {
        $cartItems = Auth::user()
            ->cartItems()
            ->with(['product.brand']) // încarcă produsul + brandul produsului
            ->get();

        return Inertia::render('pages/ViewCart', [
            'cartItems' => $cartItems,
        ]);
    }

    public function index()
    {
        $cartItems = auth()->check()
            ? Auth::user()->cartItems()->with('product')->get()
            : collect(session('cart', []));

        return response()->json([
            'cartItems' => $cartItems->map(function ($item) {
                return [
                    'id' => $item->id ?? $item['product_id'],
                    'name' => $item->product->name ?? $item['name'],
                    'brand' => $item->product->brand->name ?? $item['brand'],
                    'size' => $item->product->size ?? $item['size'],
                    'price' => $item->price ?? $item['price'],
                    'quantity' => $item->quantity ?? $item['quantity'],
                    'image' => $item->product->main_image_url ?? $item['image'],
                ];
            }),
            'total' => $cartItems->sum(function ($item) {
                return ($item->price ?? $item['price']) * ($item->quantity ?? $item['quantity']);
            })
        ]);
    }

    public function add(Product $product, Request $request)
    {
        $quantity = $request->input('quantity', 1);

        if (auth()->check()) {
            // Authenticated user - store in database
            $cartItem = Auth::user()->cartItems()->where('product_id', $product->id)->first();

            if ($cartItem) {
                $cartItem->increment('quantity', $quantity);
            } else {
                Auth::user()->cartItems()->create([
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $product->price
                ]);
            }
        } else {
            // Guest - store in session
            $cart = session()->get('cart', []);

            if (isset($cart[$product->id])) {
                $cart[$product->id]['quantity'] += $quantity;
            } else {
                $cart[$product->id] = [
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'quantity' => $quantity,
                    'price' => $product->price,
                    'image' => $product->main_image_url, // Use the accessor you defined
                    'brand' => $product->brand->name,
                    'size' => $product->size
                ];
            }

            session()->put('cart', $cart);
        }

        return response()->json([
            'success' => true,
            'cart' => [
                'count' => auth()->check()
                    ? auth()->user()->cartItems()->count()
                    : count(session('cart', [])),
                'items' => auth()->check()
                    ? auth()->user()->cartItems()->with('product')->get()->toArray()
                    : session('cart', [])
            ]
        ]);
    }

    public function update(Request $request, $cartItem)
    {
        $quantity = $request->input('quantity', 1);

        if (auth()->check()) {
            // Update database cart
            $item = CartItem::findOrFail($cartItem);
            $item->update(['quantity' => $quantity]);
        } else {
            // Update session cart
            $cart = session()->get('cart', []);
            if (isset($cart[$cartItem])) {
                $cart[$cartItem]['quantity'] = $quantity;
                session()->put('cart', $cart);
            }
        }

        return back();
    }

    public function remove($cartItem)
    {
        try {
            if (auth()->check()) {
                // For authenticated users
                CartItem::where('id', $cartItem)
                    ->where('user_id', auth()->id())
                    ->delete();
            } else {
                // For guests
                $cart = session()->get('cart', []);
                if (isset($cart[$cartItem])) {
                    unset($cart[$cartItem]);
                    session()->put('cart', $cart);
                }
            }

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error removing item: ' . $e->getMessage()
            ], 500);
        }
    }


    public function checkout()
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login to proceed to checkout');
        }

        $cartItems = Auth::user()->cartItems()->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty');
        }

        $total = $cartItems->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });

        return view('cart.checkout', compact('cartItems', 'total'));
    }
}
