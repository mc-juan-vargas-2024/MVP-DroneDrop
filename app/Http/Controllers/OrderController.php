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

        $deliveryCost  = (float) $request->input('delivery_cost', 20.00);
        $paymentMethod = $request->input('payment_method', 'contra_entrega');

        $order->update(['status' => 'confirmed']);

        $order->delivery()->create([
            'method'         => $request->input('method', 'motocicleta'),
            'cost'           => $deliveryCost,
            'estimated_time' => 30,
            'status'         => 'pending',
        ]);

        $order->payment()->create([
            'method' => $paymentMethod,
            'amount' => $order->total_amount + $deliveryCost,
            'status' => 'pending',
        ]);

        // ── Si el pago es online, redirigir a PayU ──────────────────────
        if (in_array($paymentMethod, ['tarjeta_credito', 'tarjeta_debito'])) {
            $apiKey        = trim(env('PAYU_API_KEY', '4Vj8eK4rloUd272L48hsrarnUA'));
            $merchantId    = trim(env('PAYU_MERCHANT_ID', '508029'));
            $accountId     = trim(env('PAYU_ACCOUNT_ID', '512321'));
            $test          = trim(env('PAYU_TEST', '1'));
            $payuUrl       = trim(env('PAYU_URL', 'https://sandbox.checkout.payulatam.com/ppp-web-gateway-payu/'));

            $referenceCode = 'Pedido-' . $order->id . '-' . time();
            // Para COP en PayU Sandbox es más seguro enviar el valor entero sin decimales
            $amount        = (string) intval($order->total_amount + $deliveryCost);
            $currency      = 'COP';
            $description   = 'Pedido #' . $order->id . ' en DroneDrop';
            $buyerEmail    = auth()->user()->email;

            // Firma: md5(apiKey~merchantId~referenceCode~amount~currency)
            $signature = md5("{$apiKey}~{$merchantId}~{$referenceCode}~{$amount}~{$currency}");
            $algorithmSignature = 'MD5';

            return view('payu.checkout', compact(
                'merchantId', 'accountId', 'description', 'referenceCode',
                'amount', 'currency', 'signature', 'algorithmSignature', 'test', 'buyerEmail', 'payuUrl'
            ));
        }

        // ── Pago contra entrega: flujo normal ───────────────────────────
        return redirect()->route('orders.index')->with('status', 'Pedido confirmado con éxito.');
    }

    // For Commerces to view and manage their orders
    public function commerceOrders()
    {
        $commerce = auth()->user()->commerces()->first();
        if (!$commerce) return redirect()->route('commerce.dashboard');

        $orders = $commerce->orders()->where('status', '!=', 'pending')->with('items.product', 'user')->latest()->get();
        return view('orders.commerce', compact('orders'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $order->update(['status' => $request->status]);
        return redirect()->route('commerce.orders')->with('status', 'Pedido actualizado correctamente.');
    }
}
