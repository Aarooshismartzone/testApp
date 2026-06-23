<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>

    @include('layouts.header')

    <title>Invoice Preview</title>

</head>

<body>

    <div class="container mt-5">
        <a href="/" class="btn btn-secondary mb-3">
            Home
        </a>

        <div class="card">

            <div class="card-body">

                <h2 class="mb-4">

                    {{ $invoice->invoice_number }}

                </h2>

                <p>

                    <strong>العميل:</strong>

                    {{ $invoice->customer->name }}

                </p>

                <table class="table table-bordered">

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

                <div class="mt-4">

                    <h5>

                        Grand Total:

                        {{ number_format($invoice->grand_total, 3) }}

                        KWD

                    </h5>

                </div>

                <a href="{{ route('invoice.pdf', $invoice->id) }}" class="btn btn-success">
                    Download PDF
                </a>

            </div>

        </div>

    </div>

</body>

</html>
