<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    /**
     * Prepara los datos para el checkout de PayU y retorna la vista.
     */
    public function preparePayment(Request $request)
    {
        $apiKey      = trim(env('PAYU_API_KEY', '4Vj8eK4rloUd272L48hsrarnUA'));
        $merchantId  = trim(env('PAYU_MERCHANT_ID', '508029'));
        $accountId   = trim(env('PAYU_ACCOUNT_ID', '512321'));
        $test        = trim(env('PAYU_TEST', '1'));
        $payuUrl     = trim(env('PAYU_URL', 'https://sandbox.checkout.payulatam.com/ppp-web-gateway-payu/'));

        $referenceCode = 'Pedido-' . time();
        $amount        = '20000';
        $currency      = 'COP';
        $description   = 'Pedido de prueba DroneDrop';
        $buyerEmail    = 'testbuyer@dropdrone.com';

        // Firma: md5(apiKey~merchantId~referenceCode~amount~currency)
        $signature = md5("{$apiKey}~{$merchantId}~{$referenceCode}~{$amount}~{$currency}");
        $algorithmSignature = 'MD5';

        return view('payu.checkout', compact(
            'merchantId',
            'accountId',
            'description',
            'referenceCode',
            'amount',
            'currency',
            'signature',
            'algorithmSignature',
            'test',
            'buyerEmail',
            'payuUrl'
        ));
    }

    /**
     * Webhook asíncrono de PayU (confirmationUrl).
     * Valida la firma y registra el estado de la transacción.
     */
    public function webhook(Request $request)
    {
        $apiKey     = env('PAYU_API_KEY');

        // Datos recibidos de PayU
        $sign              = $request->input('sign');
        $merchantIdRecv    = $request->input('merchant_id');
        $referenceCode     = $request->input('reference_sale');
        $amount            = $request->input('value');
        $currency          = $request->input('currency');
        $transactionState  = $request->input('state_pol');
        $transactionId     = $request->input('transaction_id');

        // Validar firma según doc PayU:
        // md5(apiKey~merchantId~referenceCode~amount_rounded~currency~transactionState)
        $amountRounded  = number_format((float) $amount, 1, '.', '');
        $expectedSign   = md5("{$apiKey}~{$merchantIdRecv}~{$referenceCode}~{$amountRounded}~{$currency}~{$transactionState}");

        if ($sign !== $expectedSign) {
            Log::warning('PayU Webhook: firma inválida', [
                'reference'     => $referenceCode,
                'received_sign' => $sign,
                'expected_sign' => $expectedSign,
            ]);
            return response('Firma inválida', 200); // PayU siempre requiere 200
        }

        // Mapear estado
        $statuses = [
            '4'   => 'APROBADA',
            '6'   => 'RECHAZADA',
            '5'   => 'EXPIRADA',
            '7'   => 'PENDIENTE',
            '104' => 'ERROR',
        ];

        $statusLabel = $statuses[$transactionState] ?? 'DESCONOCIDO';

        Log::info("PayU Webhook: transacción {$statusLabel}", [
            'reference'   => $referenceCode,
            'transaction' => $transactionId,
            'amount'      => $amount,
            'currency'    => $currency,
            'state_pol'   => $transactionState,
        ]);

        return response('OK', 200);
    }
}
