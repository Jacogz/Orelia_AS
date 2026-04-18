<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Piece;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CartController extends Controller
{
    /**
     * CART ATTRIBUTES
     * - Manages the shopping cart for authenticated users
     * - Stores piece IDs and quantities in session
     * - Relates to database models: Piece, Order, OrderItem
     */
    // Está duplicado
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display the shopping cart.
     */
    public function index(Request $request): View
    {
        $cartItems = [];
        $total = 0;

        $cartData = $request->session()->get('cart', []);

        if ($cartData) {
            foreach ($cartData as $pieceId => $quantity) {
                $piece = Piece::find($pieceId);
                if ($piece) {
                    $subtotal = $piece->price * $quantity;
                    $cartItems[$pieceId] = [
                        'piece' => $piece,
                        'quantity' => $quantity,
                        'subtotal' => $subtotal,
                    ];
                    $total += $subtotal;
                }
            }
        }

        $viewData = [];
        // Falta lang
        $viewData['title'] = 'Cart - Orelia';
        $viewData['subtitle'] = 'Shopping Cart';
        $viewData['cartItems'] = $cartItems;
        $viewData['total'] = $total;

        return view('user.cart.index')->with('viewData', $viewData);
    }

    // Comentario duplica codigo
    /**
     * Add a piece to the cart.
     */
    public function add(string $id, Request $request): RedirectResponse
    {
        $piece = Piece::find($id);

        if (! $piece) {
            return back()->with('error', 'Piece not found');
        }

        $cart = $request->session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]++;
        } else {
            $cart[$id] = 1;
        }

        $request->session()->put('cart', $cart);

        return back()->with('success', 'Product added to cart');
    }

    /**
     * Update the quantity of a piece in the cart.
     */
    public function update(string $id, Request $request): RedirectResponse
    {
        $quantity = $request->input('quantity', 1);

        if ($quantity < 1) {
            return $this->remove($id, $request);
        }

        $piece = Piece::find($id);

        if (! $piece) {
            return back()->with('error', 'Piece not found');
        }

        $cart = $request->session()->get('cart', []);
        $cart[$id] = $quantity;
        $request->session()->put('cart', $cart);

        return back()->with('success', 'Cart updated');
    }

    /**
     * Remove a piece from the cart.
     */
    public function remove(string $id, Request $request): RedirectResponse
    {
        $cart = $request->session()->get('cart', []);
        unset($cart[$id]);
        $request->session()->put('cart', $cart);

        return back()->with('success', 'Product removed from cart');
    }

    /**
     * Clear all items from the cart.
     */
    public function removeAll(Request $request): RedirectResponse
    {
        $request->session()->forget('cart');

        return back()->with('success', 'Cart cleared');
    }

    /**
     * Checkout: Create an Order from cart items.
     */
    public function checkout(Request $request): RedirectResponse
    {
        $user = Auth::user();
        $cartData = $request->session()->get('cart', []);

        if (empty($cartData)) {
            return back()->with('error', 'Cart is empty');
        }

        //  Estándar fill
        $order = Order::create([
            'client_id' => $user->id,
            'total' => 0,
            'status' => 'pending',
            'payment_method' => 'pending',
            'payment_status' => 'pending',
        ]);

        $total = 0;

        foreach ($cartData as $pieceId => $quantity) {
            $piece = Piece::find($pieceId);

            if ($piece) {
                // getter
                $subtotal = $piece->price * $quantity;

                OrderItem::create([
                    'order_id' => $order->id,
                    'piece_id' => $pieceId,
                    'unit_price' => $piece->price,
                    'quantity' => $quantity,
                    'subtotal' => $subtotal,
                ]);

                $total += $subtotal;
            }
        }

        $order->update(['total' => $total]);

        $request->session()->forget('cart');

        // Nombre de ruta, no url
        return redirect('/orders')->with('success', 'Order created successfully');
    }
}
