<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagar con PayU — DroneDrop</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #fff7f0 0%, #ffe8d0 100%);
            min-height: 100vh;
            display: flex; align-items: center; justify-content: center;
            padding: 2rem;
        }
        .card {
            background: white; border-radius: 24px;
            padding: 2.5rem; max-width: 480px; width: 100%;
            box-shadow: 0 20px 60px rgba(255,107,0,.15);
            border: 1px solid #ffe0c0;
        }
        .brand { font-size: 1.6rem; font-weight: 800; color: #ff6b00; margin-bottom: 1.5rem; text-align: center; }
        .brand span { color: #1a1a1a; }
        h2 { font-size: 1.2rem; font-weight: 700; color: #1a1a1a; margin-bottom: 1.2rem; }
        .summary { background: #fff7f0; border: 1px solid #ffe0c0; border-radius: 14px; padding: 1.2rem; margin-bottom: 1.5rem; }
        .summary-row { display: flex; justify-content: space-between; font-size: .9rem; margin-bottom: .6rem; }
        .summary-row:last-child { margin-bottom: 0; font-weight: 700; font-size: 1rem; border-top: 1px solid #ffe0c0; padding-top: .6rem; margin-top: .6rem; }
        .label { color: #888; }
        .value { color: #1a1a1a; }
        .total-value { color: #ff6b00; }
        .sandbox-badge {
            display: inline-block; background: #fff3cd; color: #856404;
            border: 1px solid #ffc107; border-radius: 50px;
            font-size: .72rem; font-weight: 700; padding: .3rem .9rem; margin-bottom: 1.2rem;
        }
        .btn-pay {
            display: block; width: 100%; padding: 1rem;
            background: #ff6b00; color: white; font-size: 1.05rem; font-weight: 800;
            border: none; border-radius: 14px; cursor: pointer;
            box-shadow: 0 6px 20px rgba(255,107,0,.4);
            transition: all .2s; letter-spacing: .02em;
        }
        .btn-pay:hover { background: #e55a00; transform: translateY(-2px); box-shadow: 0 10px 28px rgba(255,107,0,.5); }
        .btn-pay:active { transform: translateY(0); }
        .note { text-align: center; color: #aaa; font-size: .78rem; margin-top: 1rem; }
    </style>
</head>
<body>

    <div class="card">
        <div class="brand">Drone<span>Drop</span></div>
        <span class="sandbox-badge">🧪 Modo Sandbox — Prueba</span>

        <h2>Resumen del pedido</h2>
        <div class="summary">
            <div class="summary-row">
                <span class="label">Referencia</span>
                <span class="value">{{ $referenceCode }}</span>
            </div>
            <div class="summary-row">
                <span class="label">Descripción</span>
                <span class="value">{{ $description }}</span>
            </div>
            <div class="summary-row">
                <span class="label">Moneda</span>
                <span class="value">{{ $currency }}</span>
            </div>
            <div class="summary-row">
                <span class="label">Total</span>
                <span class="total-value">$ {{ number_format($amount, 0, ',', '.') }}</span>
            </div>
        </div>

        <form action="{{ $payuUrl }}" method="POST">
            <input type="hidden" name="merchantId"      value="{{ $merchantId }}">
            <input type="hidden" name="accountId"       value="{{ $accountId }}">
            <input type="hidden" name="description"     value="{{ $description }}">
            <input type="hidden" name="referenceCode"   value="{{ $referenceCode }}">
            <input type="hidden" name="amount"          value="{{ $amount }}">
            <input type="hidden" name="tax"             value="0">
            <input type="hidden" name="taxReturnBase"   value="0">
            <input type="hidden" name="currency"        value="{{ $currency }}">
            <input type="hidden" name="signature"       value="{{ $signature }}">
            <input type="hidden" name="test"            value="{{ $test }}">
            <input type="hidden" name="buyerEmail"      value="{{ $buyerEmail }}">
            <input type="hidden" name="confirmationUrl" value="{{ url('/payu/webhook') }}">
            <input type="hidden" name="responseUrl"     value="{{ url('/orders') }}">

            <button type="submit" class="btn-pay">🔒 Pagar con PayU</button>
        </form>

        <p class="note">Serás redirigido al portal seguro de PayU para completar el pago.</p>
    </div>

</body>
</html>
