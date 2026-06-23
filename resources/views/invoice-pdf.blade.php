<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>

    <meta charset="utf-8">

    <style>
        body {
            font-family: DejaVu Sans;
            direction: rtl;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid #000;
        }

        th,
        td {
            padding: 8px;
        }
    </style>

</head>

<body>

    <h2>

        {{ $invoice->invoice_number }}

    </h2>

    <p>

        <strong>العميل:</strong>

        {{ $invoice->customer->name }}

    </p>

    <table>

        <thead>

            <tr>

                <th>الصنف</th>

                <th>الكمية</th>

                <th>السعر</th>

                <th>الإجمالي</th>

            </tr>

        </thead>

        <tbody>

            @foreach ($invoice->items as $item)
                <tr>

                    <td>{{ $item->item_name }}</td>

                    <td>{{ $item->quantity }}</td>

                    <td>{{ number_format($item->unit_price, 3) }}</td>

                    <td>{{ number_format($item->line_total, 3) }}</td>

                </tr>
            @endforeach

        </tbody>

    </table>

    <br>

    <h3>

        الإجمالي النهائي:

        {{ number_format($invoice->grand_total, 3) }}

        KWD

    </h3>

</body>

</html>
