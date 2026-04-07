<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // For users to view their history
    public function index()
    {
        $orders = auth()->user()->orders()->where('status', '!=', 'pending')->latest()->get();
        return view('orders.index', compact('orders'));
    }

    public function viewCart()
    {
        $orders = auth()->user()->orders()->where('status', 'pending')->with('items.product')->get();
        return view('orders.cart', compact('orders'));
    }

    public function addToCart(Request $request, Product $product)
    {
        $order = auth()->user()->orders()->where('status', 'pending')->where('commerce_id', $product->commerce_id)->first();
        
        if (!$order) {
            $order = auth()->user()->orders()->create([
                'commerce_id' => $product->commerce_id,
                'total_amount' => 0,
                'status' => 'pending'
            ]);
        }
        
        $item = $order->items()->where('product_id', $product->id)->first();
        $qty = $request->input('quantity', 1);
        
        if ($item) {
            $item->update(['quantity' => $item->quantity + $qty]);
        } else {
            $order->items()->create([
                'product_id' => $product->id,
                'quantity' => $qty,
                'price' => $product->price
            ]);
        }
        
        $order->update(['total_amount' => $order->items()->sum(DB::raw('price * quantity'))]);
        return redirect()->back()->with('status', 'Producto agregado al carrito.');
    }

    public function checkout(Request $request, Order $order)
    {
        if ($order->user_id !== auth()->id() || $order->status !== 'pending') {
            abort(403);
        }

        $order->update(['status' => 'confirmed']);
        
        $order->delivery()->create([
            'method' => $request->input('method', 'motocicleta'),
            'cost' => $request->input('delivery_cost', 5.00),
            'estimated_time' => 30, // minutes
            'status' => 'pending'
        ]);

        $order->payment()->create([
            'method' => $request->input('payment_method', 'contra_entrega'),
            'amount' => $order->total_amount + $request->input('delivery_cost', 5.00),
            'status' => 'approved'
        ]);

        return redirect()->route('orders.index')->with('status', 'Pedido confirmado con exito.');
    }

    // For Commerces to view and manage their orders
    public function commerceOrders()
    {
        $commerce = auth()->user()->commerces()->first();
        if (!$commerce) return redirect()->route('commerce.dashboard');

        $orders = $commerce->orders()->where('status', '!=', 'pending')->latest()->get();
        return view('orders.commerce', compact('orders'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $order->update(['status' => $request->status]);
        return redirect()->back()->with('status', 'Estado del pedido actualizado.');
    }
}
