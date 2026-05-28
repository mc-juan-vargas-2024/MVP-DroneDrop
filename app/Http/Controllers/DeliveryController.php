<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use App\Models\Order;
use Illuminate\Http\Request;

/**
 * EntregaController (DeliveryController)
 * Caso de uso: Seleccionar método de entrega
 * Vista: Lista de métodos de entrega  →  Pedido::setMetodoEntrega()
 */
class DeliveryController extends Controller
{
    /** Métodos de entrega disponibles en la plataforma */
    private const METODOS = [
        'motocicleta' => 'Motocicleta',
        'dron'        => 'Dron',
        'bicicleta'   => 'Bicicleta',
    ];

    /**
     * Mostrar la lista de métodos de entrega disponibles para un pedido.
     * Corresponde a la vista "Lista de métodos de entrega".
     */
    public function index(Order $order)
    {
        if ($order->user_id !== auth()->id() || $order->status !== 'pending') {
            abort(403);
        }

        $metodos = self::METODOS;
        return view('delivery.index', compact('order', 'metodos'));
    }

    /**
     * Establecer el método de entrega en el pedido (Pedido::setMetodoEntrega).
     * Guarda el método seleccionado en la entrega asociada al pedido.
     */
    public function setMetodoEntrega(Request $request, Order $order)
    {
        if ($order->user_id !== auth()->id() || $order->status !== 'pending') {
            abort(403);
        }

        $request->validate([
            'method' => 'required|in:' . implode(',', array_keys(self::METODOS)),
            'cost'   => 'nullable|numeric|min:0',
        ]);

        // Crear o actualizar la entrega del pedido
        $order->delivery()->updateOrCreate(
            ['order_id' => $order->id],
            [
                'method'         => $request->method,
                'cost'           => $request->input('cost', 20.00),
                'estimated_time' => 30,
                'status'         => 'pending',
            ]
        );

        return redirect()->route('pago.index', $order)
            ->with('status', 'Método de entrega seleccionado: ' . self::METODOS[$request->method]);
    }

    /**
     * Vista de seguimiento de una entrega (tracking).
     */
    public function tracking(Delivery $delivery)
    {
        if ($delivery->order->user_id !== auth()->id()) {
            abort(403);
        }

        return view('delivery.tracking', compact('delivery'));
    }
}

