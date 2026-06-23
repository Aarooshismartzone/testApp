<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.header')
    <title>Invoice Assessment - Home</title>

    <style>
        body {
            background: #f8f9fa;
        }

        .dashboard-card {
            background: #fff;
            border-radius: 12px;
            padding: 30px;
            margin-top: 50px;
            box-shadow: 0 0 15px rgba(0, 0, 0, .08);
        }

        .action-btn {
            width: 100%;
            margin-bottom: 15px;
            padding: 15px;
            font-size: 18px;
        }

        .title {
            font-weight: 600;
            margin-bottom: 10px;
        }

        .subtitle {
            color: #6c757d;
            margin-bottom: 30px;
        }
    </style>
</head>

<body>

    <div class="container">

        <div class="row justify-content-center">

            <div class="col-md-8">

                <div class="dashboard-card">

                    <h2 class="text-center title">
                        Laravel Invoice Assessment
                    </h2>

                    <p class="text-center subtitle">
                        Arabic RTL Invoice / Quotation Demo
                    </p>

                    <div class="d-grid gap-2">

                        <a href="{{ route('invoice.create') }}" class="btn btn-primary action-btn">
                            Create Invoice
                        </a>

                        @if ($latestInvoice)
                            <a href="{{ route('invoice.preview', $latestInvoice->id) }}"
                                class="btn btn-success action-btn">
                                Preview Latest Invoice
                            </a>
                        @endif
                        <a href="{{ route('invoice.index') }}" class="btn btn-success action-btn">
                            View All Invoices
                        </a>
                    </div>

                    <hr>

                    <div class="mt-3">

                        <h5>Included Features</h5>

                        <ul>
                            <li>Laravel 12</li>
                            <li>Blade Templates</li>
                            <li>Arabic RTL Layout</li>
                            <li>Dynamic Invoice Rows</li>
                            <li>Server-side Calculations</li>
                            <li>MySQL Storage</li>
                            <li>PDF Generation</li>
                        </ul>

                    </div>

                </div>

            </div>

        </div>

    </div>

</body>

</html>
