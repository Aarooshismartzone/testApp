<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.header')
    <title>All Invoices</title>
</head>

<body>

    <div class="container mt-5">
        <a href="/" class="btn btn-secondary mb-3">
            Home
        </a>
        <div class="card">

            <div class="card-header">
                <h3>All Invoices</h3>
            </div>

            <div class="card-body">

                <table class="table table-bordered table-striped">

                    <thead>

                        <tr>
                            <th>ID</th>
                            <th>Invoice Number</th>
                            <th>Customer</th>
                            <th>Grand Total</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>

                    </thead>

                    <tbody>

                        @forelse($invoices as $invoice)
                            <tr>

                                <td>{{ $invoice->id }}</td>

                                <td>{{ $invoice->invoice_number }}</td>

                                <td>{{ $invoice->customer->name }}</td>

                                <td>{{ number_format($invoice->grand_total, 3) }}</td>

                                <td>{{ $invoice->created_at->format('d M Y') }}</td>

                                <td>

                                    <a href="{{ route('invoice.preview', $invoice->id) }}" class="btn btn-sm btn-primary">
                                        Preview
                                    </a>

                                    <a href="{{ route('invoice.pdf', $invoice->id) }}" class="btn btn-sm btn-success">
                                        PDF
                                    </a>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="6" class="text-center">
                                    No invoices found.
                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</body>

</html>
