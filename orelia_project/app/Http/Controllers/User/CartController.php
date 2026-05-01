<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Piece;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(Request $request): View
    {
        $cartItems = [];
        $total = 0;

        $cartData = $request->session()->get('cart', []);

        if ($cartData) {
            $pieceIds = array_keys($cartData);
            $pieces = Piece::whereIn('id', $pieceIds)->get();
            $piecesMap = $pieces->keyBy('id');

            foreach ($cartData as $pieceId => $quantity) {
                if (isset($piecesMap[$pieceId])) {
                    $piece = $piecesMap[$pieceId];
                    $subtotal = $piece->getPrice() * $quantity;
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
        $viewData['title'] = __('cart.title');
        $viewData['subtitle'] = __('cart.subtitle');
        $viewData['cartItems'] = $cartItems;
        $viewData['total'] = $total;

        return view('cart.index')->with('viewData', $viewData);
    }

    public function add(string $id, Request $request): RedirectResponse
    {
        $validationData = OrderItem::validateCartAdd($request, $id);
        $pieceId = $validationData['piece_id'];

        $cart = $request->session()->get('cart', []);

        if (isset($cart[$pieceId])) {
            $cart[$pieceId]++;
        } else {
            $cart[$pieceId] = 1;
        }

        $request->session()->put('cart', $cart);

        return back()->with('success', __('cart.product_added'));
    }

    public function update(string $id, Request $request): RedirectResponse
    {
        $validationData = OrderItem::validateCartUpdate($request, $id);
        $pieceId = $validationData['piece_id'];
        $quantity = $validationData['quantity'];

        if ($quantity < 1) {
            return $this->remove((string) $pieceId, $request);
        }

        $cart = $request->session()->get('cart', []);
        $cart[$pieceId] = $quantity;
        $request->session()->put('cart', $cart);

        return back()->with('success', __('cart.updated'));
    }

    public function remove(string $id, Request $request): RedirectResponse
    {
        $cart = $request->session()->get('cart', []);
        unset($cart[$id]);
        $request->session()->put('cart', $cart);

        return back()->with('success', __('cart.product_removed'));
    }

    public function removeAll(Request $request): RedirectResponse
    {
        $request->session()->forget('cart');

        return back()->with('success', __('cart.cleared'));
    }

    public function checkout(Request $request): RedirectResponse
    {
        $user = Auth::user();
        $cartData = $request->session()->get('cart', []);

        if (empty($cartData)) {
            return back()->with('error', __('cart.empty'));
        }

        $cartData = OrderItem::validateCartCheckout($cartData);

        try {
            $pieceIds = array_keys($cartData);
            $pieces = Piece::whereIn('id', $pieceIds)->get();
            $piecesMap = $pieces->keyBy('id');
            $order = new Order;
            $order->fill([
                'client_id' => $user->getId(),
                'total' => 0,
                'status' => 'pending',
                'payment_method' => 'pending',
                'payment_status' => 'pending',
            ]);
            $order->save();

            $total = 0;
            foreach ($cartData as $pieceId => $quantity) {
                $piece = $piecesMap[$pieceId];

                $orderItem = new OrderItem;
                $orderItem->fill([
                    'order_id' => $order->getId(),
                    'piece_id' => $piece->getId(),
                    'unit_price' => $piece->getPrice(),
                    'quantity' => $quantity,
                ]);
                $orderItem->setSubtotal($orderItem->calculateSubtotal());
                $orderItem->save();

                $total += $orderItem->getSubtotal();
            }

            $order->fill(['total' => $total]);
            $order->save();

            $request->session()->forget('cart');

            return redirect()->route('cart.index')->with('success', __('cart.order_created'));
        } catch (QueryException $e) {
            return back()->with('error', __('cart.order_failed'));
        } catch (\Exception $e) {
            return back()->with('error', __('cart.order_failed'));
        }
    }
}
