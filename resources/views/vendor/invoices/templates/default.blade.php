@php
    $venta = $invoice->venta ?? null;
    $totalAbonado = $venta?->abonos->sum('monto') ?? 0;
    $saldoPendiente = $venta ? $venta->total - $totalAbonado : 0;
@endphp
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <title>{{ $invoice->name }}</title>
    <style>
        body {
            font-family: "DejaVu Sans", sans-serif;
            font-size: 10px;
            color: #333;
            background-color: #fff;
            margin: 25pt;
        }

        h1, h4 {
            font-weight: bold;
            color: #1F2937;
        }

        h1 {
            font-size: 20px;
            margin-bottom: 10px;
        }

        h4 {
            font-size: 14px;
            margin-bottom: 5px;
        }

        .section {
            margin-top: 25px;
        }

        .info-block {
            background-color: #F3F4F6;
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        .split-columns {
            display: flex;
            justify-content: space-between;
            gap: 40px;
        }

        .split-columns .column {
            width: 48%;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .table th,
        .table td {
            border: 1px solid #E5E7EB;
            padding: 8px;
            text-align: left;
        }

        .table th {
            background-color: #F9FAFB;
            font-weight: bold;
        }

        .text-right {
            text-align: right;
        }

        .total-row td {
            font-weight: bold;
            background-color: #E5E7EB;
        }

        .footer-info {
            margin-top: 25px;
        }

        .logo {
            max-height: 80px;
            margin-bottom: 15px;
        }

        .label {
            font-weight: bold;
            color: #111827;
        }

        .text-green {
            color: #059669;
        }

        .text-red {
            color: #DC2626;
        }
    </style>
</head>

<body>

   {{-- LOGO --}}
@if($invoice->logo)
    <img src="{{ public_path('vendor/invoices/shoesandi-logo-removebg.png') }}" class="logo" alt="Logo Calzado">
@endif

    <h1>Factura de Venta</h1>

    {{-- INFO GENERAL --}}
    <div class="info-block">
        <div class="split-columns">
            <div>
                <p><strong>N° Factura:</strong> {{ $venta->numero_factura }}</p>
                <p><span class="label">Fecha:</span> {{ $invoice->getDate() }}</p>
            </div>
            <div class="text-right">
                @if($invoice->status)
                    <p><span class="label">Estado:</span> {{ $invoice->status }}</p>
                @endif
            </div>
        </div>
    </div>

    {{-- INFORMACIÓN DE VENDEDOR Y CLIENTE --}}
    <div class="section">
        <table style="width: 100%;">
            <tr>
                <td style="width: 48%; vertical-align: top;">
                    <h4>Información del Vendedor</h4>
                    <p><strong>{{ $invoice->seller->name }}</strong></p>
                    @foreach($invoice->seller->custom_fields as $key => $value)
                        <p>{{ ucfirst($key) }}: {{ $value }}</p>
                    @endforeach
                </td>

                <td style="width: 4%;"></td>

                <td style="width: 48%; vertical-align: top; text-align: right;">
                    <h4>Información del Cliente</h4>
                    <p><strong>{{ $invoice->buyer->name }}</strong></p>
                    @foreach($invoice->buyer->custom_fields as $key => $value)
                        <p>{{ ucfirst($key) }}: {{ $value }}</p>
                    @endforeach
                </td>
            </tr>
        </table>
    </div>

   {{-- TABLA DE ITEMS --}}
<table class="table section">
    <thead>
        <tr>
            <th>Descripción</th>
            @if($invoice->hasItemUnits)
                <th>Unidad</th>
            @endif
            <th>Cantidad</th>
            <th class="text-right">Precio Unitario</th>
            <th class="text-right">Subtotal</th>
        </tr>
    </thead>
    <tbody>
        @foreach($invoice->items as $item)
            <tr>
                <td>{{ $item->title }}</td>
                @if($invoice->hasItemUnits)
                    <td>{{ $item->units }}</td>
                @endif
                <td>{{ $item->quantity }}</td>
                <td class="text-right">{{ $invoice->formatCurrency($item->price_per_unit) }}</td>
                <td class="text-right">{{ $invoice->formatCurrency($item->sub_total_price) }}</td>
            </tr>
        @endforeach

        {{-- TOTAL --}}
        <tr class="total-row">
            <td colspan="{{ $invoice->table_columns - 1 }}" class="text-right">Total</td>
            <td class="text-right">{{ $invoice->formatCurrency($invoice->total_amount) }}</td>
        </tr>

       {{-- DETALLE DE ABONOS --}}
@if($venta && $venta->abonos->count() > 0)
    {{-- Encabezado --}}
    <tr>
        <td colspan="{{ $invoice->table_columns }}" style="background-color:#F3F4F6; font-weight:bold;">
            📌 Detalle de Abonos
        </td>
    </tr>

    {{-- Lista de abonos con fecha --}}
@foreach($venta->abonos as $abono)
    <tr>
        {{-- Fecha del abono --}}
        <td>
            📅 {{ \Carbon\Carbon::parse($abono->fecha_abono)->format('d/m/Y') }}
        </td>
        {{-- Texto "Abono" --}}
        <td colspan="{{ $invoice->table_columns - 2 }}">
            💵 Abono
        </td>
        {{-- Monto del abono --}}
        <td class="text-right text-green font-bold">
            {{ $invoice->formatCurrency($abono->monto) }}
        </td>
    </tr>
@endforeach
        
@endif
{{-- ABONOS Y SALDO PENDIENTE --}}
@if($totalAbonado > 0)
    {{-- Total Abonado --}}
    <tr style="background-color:#F3F4F6;">
        <td colspan="{{ $invoice->table_columns - 1 }}" class="text-right text-green font-bold">
            🧾 Total Abonado
        </td>
        <td class="text-right text-green">
            - {{ $invoice->formatCurrency($totalAbonado) }}
        </td>
    </tr>

    {{-- Saldo pendiente --}}
    <tr style="background-color:#F3F4F6;">
        <td colspan="{{ $invoice->table_columns - 1 }}" class="text-right text-red font-bold">
            💰 Saldo Pendiente
        </td>
        <td class="text-right text-red">
            {{ $invoice->formatCurrency($saldoPendiente) }}
        </td>
    </tr>
@endif



    </tbody>
</table>

{{-- NOTAS --}}
<div class="footer-info">
    @if($invoice->notes)
        <p><strong>Notas:</strong> {{ $invoice->notes }}</p>
    @endif

    @php
        $formatter = new \NumberFormatter('es_CO', \NumberFormatter::SPELLOUT);
        $entero = floor($invoice->total_amount);
        $centavos = round(($invoice->total_amount - $entero) * 100);
        $valorEnLetras = ucfirst($formatter->format($entero));

        // Si termina en "millón" o "millones", agregar "de"
        if (preg_match('/(millón|millones)$/i', $valorEnLetras)) {
            $valorEnLetras .= ' de';
        }

        $centavosEnLetras = $centavos > 0
            ? ' con ' . $formatter->format($centavos) . ' centavos'
            : '';
    @endphp

    <p><strong>Valor en letras:</strong> {{ $valorEnLetras }} pesos{{ $centavosEnLetras }}</p>
    <p><strong>Fecha límite de pago:</strong> {{ $invoice->getPayUntilDate() }}</p>
</div>

    </div>

</body>
</html>
