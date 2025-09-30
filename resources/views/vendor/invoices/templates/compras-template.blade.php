<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Compra</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 14px;
            color: #1e293b;
            background: #f0f4f8;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 95%;
            margin: 30px auto;
            background: #ffffff;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.08);
        }
        h1 {
            text-align: center;
            color: #0f172a;
            font-size: 28px;
            margin-bottom: 5px;
        }
        .header {
            text-align: center;
            margin-bottom: 35px;
        }
        .header p {
            color: #475569;
            font-size: 15px;
        }
        .section-title {
            margin: 25px 0 12px;
            font-size: 18px;
            font-weight: bold;
            color: #0f766e;
            border-left: 6px solid #1d4ed8;
            padding-left: 10px;
        }
        .card {
            background: #f9fafb;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            border-radius: 10px;
            overflow: hidden;
        }
        thead {
            background: linear-gradient(to right, #1d4ed8, #16a34a);
            color: #ffffff;
        }
        th {
            padding: 12px;
            text-align: left;
            font-size: 14px;
        }
        td {
            border: 1px solid #e5e7eb;
            padding: 10px;
            font-size: 14px;
            color: #334155;
        }
        tr:nth-child(even) {
            background: #f1f5f9;
        }
        .total {
            text-align: right;
            font-size: 20px;
            font-weight: bold;
            margin-top: 25px;
            color: #16a34a;
        }
        .footer {
            text-align: center;
            margin-top: 35px;
            font-size: 13px;
            color: #64748b;
            border-top: 1px solid #e2e8f0;
            padding-top: 12px;
        }
        /* Innovación visual */
        .badge {
            display: inline-block;
            padding: 6px 12px;
            background: #1d4ed8;
            color: #fff;
            border-radius: 20px;
            font-size: 12px;
            margin-top: 5px;
        }
        .highlight {
            color: #1d4ed8;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Encabezado -->
        <div class="header">
            <h1> Reporte de Compra</h1>
            <p><strong class="highlight">Fecha del reporte:</strong> {{ now()->format('d/m/Y H:i') }}</p>
           
        </div>

        <!-- Datos del proveedor -->
        <h2 class="section-title">Proveedor</h2>
        <div class="card">
            <table>
                <tr>
                    <th>Nombre</th>
                    <td>{{ $invoice->buyer->name ?? 'Sin proveedor' }}</td>
                </tr>
                <tr>
                    <th>Correo</th>
                    <td>{{ $invoice->buyer->custom_fields['Correo'] ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Teléfono</th>
                    <td>{{ $invoice->buyer->custom_fields['Teléfono'] ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Dirección</th>
                    <td>{{ $invoice->buyer->custom_fields['Dirección'] ?? 'N/A' }}</td>
                </tr>
            </table>
        </div>

        <!-- Detalle de productos -->
        <h2 class="section-title">Detalle de Compra</h2>
        <div class="card">
            <table>
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoice->items as $item)
                        <tr>
                            <td>{{ $item->title }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>$ {{ number_format($item->price_per_unit, 2, ',', '.') }}</td>
                            <td>$ {{ number_format($item->sub_total_price, 2, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Total -->
        <p class="total"> Total: $ {{ number_format($invoice->total_amount, 2, ',', '.') }}</p>

        <!-- Pie -->
        <div class="footer">
             Reporte generado automáticamente por el <strong>Sistema de Compras</strong>
        </div>
    </div>
</body>
</html>
