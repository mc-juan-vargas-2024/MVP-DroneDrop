<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use Illuminate\Http\Request;

class CourierController extends Controller
{
    public function available()
    {
        $deliveries = Delivery::where('status', 'pending')
    ->whereHas('order', fn($q) => $q->where('status', 'ready'))
    ->with('order.commerce', 'order.user')
    ->get();
        return view('courier.available', compact('deliveries'));
    }

    public function accept(Delivery $delivery)
    {
        if ($delivery->status !== 'pending') {
            return redirect()->back()->with('error', 'El pedido ya fue tomado.');
        }

        $delivery->update([
            'courier_id' => auth()->id(),
            'status' => 'accepted'
        ]);

        $delivery->order->update(['status' => 'in_process']);

        return redirect()->route('courier.my')->with('status', 'Pedido aceptado.');
    }

    public function complete(Delivery $delivery)
    {
        if ($delivery->courier_id !== auth()->id()) {
            abort(403);
        }

        $delivery->update(['status' => 'delivered']);
        $delivery->order->update(['status' => 'delivered']);

        return redirect()->route('courier.available')->with('status', '¡Entrega confirmada exitosamente! ✅');
    }

    public function myDeliveries()
    {
        $deliveries = auth()->user()->deliveries()->with('order.commerce', 'order.user')->latest()->get();
        return view('courier.history', compact('deliveries'));
    }
}
