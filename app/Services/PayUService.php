<?php

namespace App\Services;

class PayUService
{
    /**
     * Mockup for PayU Payment Processing
     */
    public function processPayment($amount, $method, $userDetails)
    {
        if ($method === 'contra_entrega') {
            return [
                'status' => 'approved',
                'transaction_id' => null,
                'message' => 'Pago contra entrega registrado.'
            ];
        }

        // Simulate credit/debit validation
        $success = rand(1, 100) > 10; // 90% success rate

        if ($success) {
            return [
                'status' => 'approved',
                'transaction_id' => 'PAYU-' . strtoupper(uniqid()),
                'message' => 'Transaccion aprobada.'
            ];
        }

        return [
            'status' => 'declined',
            'transaction_id' => 'PAYU-' . strtoupper(uniqid()),
            'message' => 'Fondos insuficientes o tarjeta denegada.'
        ];
    }
}
