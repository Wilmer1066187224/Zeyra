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
        <img src="{{ $invoice->getLogo() }}" class="logo" alt="Logo">
    @endif

    <h1>Factura de Venta</h1>

    {{-- INFO GENERAL --}}
    <div class="info-block">
        <div class="split-columns">
            <div>
                <p><span class="label">Número:</span> {{ $invoice->getSerialNumber() }}</p>
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

            {{-- ABONOS Y SALDO PENDIENTE --}}
            @if($totalAbonado > 0)
                <tr>
                    <td colspan="{{ $invoice->table_columns - 1 }}" class="text-right text-green font-bold">🧾 Total Abonado</td>
                    <td class="text-right text-green">- {{ $invoice->formatCurrency($totalAbonado) }}</td>
                </tr>
                <tr>
                    <td colspan="{{ $invoice->table_columns - 1 }}" class="text-right text-red font-bold">💰 Saldo Pendiente</td>
                    <td class="text-right text-red">{{ $invoice->formatCurrency($saldoPendiente) }}</td>
                </tr>
            @endif
        </tbody>
    </table>

    {{-- NOTAS --}}
    <div class="footer-info">
        @if($invoice->notes)
            <p><strong>Notas:</strong> {{ $invoice->notes }}</p>
        @endif

        <p><strong>Valor en letras:</strong> {{ $invoice->getTotalAmountInWords() }}</p>
        <p><strong>Fecha límite de pago:</strong> {{ $invoice->getPayUntilDate() }}</p>
    </div>

</body>
</html>
