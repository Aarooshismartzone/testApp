@php
    $labels = [
        // Page
        'title' => 'إنشاء فاتورة', // Create Invoice

        // Customer
        'customer' => 'العميل', // Customer
        'select_customer' => 'اختر العميل', // Select Customer

        // Items Table
        'item' => 'الصنف', // Item
        'quantity' => 'الكمية', // Quantity
        'price' => 'السعر', // Price
        'discount' => 'الخصم', // Discount
        'tax' => 'الضريبة', // Tax
        'total' => 'الإجمالي', // Total
        'delete' => 'حذف', // Delete

        // Buttons
        'add_item' => 'إضافة صنف', // Add Item
        'save_invoice' => 'حفظ الفاتورة', // Save Invoice

        // Totals
        'subtotal' => 'الإجمالي الفرعي', // Subtotal
        'tax_total' => 'إجمالي الضريبة', // Total Tax
        'grand_total' => 'الإجمالي النهائي', // Grand Total

        // Misc
        'remove' => 'حذف', // Remove
    ];
@endphp
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    @include('layouts.header')
    <title>إنشاء فاتورة</title>

    <style>
        body {
            background: #f8f9fa;
            font-family: 'Cairo', sans-serif;
        }

        .invoice-card {
            background: #fff;
            padding: 25px;
            border-radius: 10px;
            margin-top: 30px;
            box-shadow: 0 0 10px rgba(0, 0, 0, .08);
        }

        table input {
            min-width: 100px;
        }

        .totals-box {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
        }
    </style>
</head>

<body>

    <div class="container">

        <div class="invoice-card">

            <h2 class="mb-4 text-center">
                <title>{{ $labels['title'] }}</title>
            </h2>

            <form method="POST" action="{{ route('invoice.store') }}">
                @csrf

                <div class="row mb-4">

                    <div class="col-md-6">
                        <label class="form-label">
                            {{ $labels['customer'] }}
                        </label>

                        <select name="customer_id" class="form-select" required>

                            <option value="">
                                {{ $labels['select_customer'] }}
                            </option>

                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}">
                                    {{ $customer->name }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                </div>

                <div class="table-responsive">

                    <table class="table table-bordered text-center" id="itemsTable">

                        <thead class="table-light">
                            <tr>
                                <th>{{ $labels['item'] }}</th>
                                <th>{{ $labels['quantity'] }}</th>
                                <th>{{ $labels['price'] }}</th>
                                <th>{{ $labels['discount'] }} %</th>
                                <th>{{ $labels['tax'] }} %</th>
                                <th>{{ $labels['total'] }}</th>
                                <th>{{ $labels['delete'] }}</th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <td>
                                    <input type="text" name="item_name[]" class="form-control" required>
                                </td>

                                <td>
                                    <input type="number" name="quantity[]" class="form-control qty" value="1">
                                </td>

                                <td>
                                    <input type="number" step="0.001" name="unit_price[]" class="form-control price">
                                </td>

                                <td>
                                    <input type="number" step="0.01" name="discount[]" class="form-control discount"
                                        value="0">
                                </td>

                                <td>
                                    <input type="number" step="0.01" name="tax[]" class="form-control tax"
                                        value="0">
                                </td>

                                <td>
                                    <input type="text" class="form-control line_total" readonly>
                                </td>

                                <td>
                                    <button type="button" class="btn btn-danger remove-row">
                                        X
                                    </button>
                                </td>
                            </tr>

                        </tbody>

                    </table>

                </div>

                <button type="button" class="btn btn-primary mb-3" id="addRow">
                    {{ $labels['add_item'] }}
                </button>

                <div class="row">

                    <div class="col-md-4 ms-auto">

                        <div class="totals-box">

                            <div class="mb-2">
                                <strong>{{ $labels['subtotal'] }}:</strong>
                                <span id="subtotal">0.000</span>
                            </div>

                            <div class="mb-2">
                                <strong>{{ $labels['tax_total'] }}:</strong>
                                <span id="tax_total">0.000</span>
                            </div>

                            <div>
                                <strong>{{ $labels['grand_total'] }}:</strong>
                                <span id="grand_total">0.000</span>
                            </div>

                        </div>

                    </div>

                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-success">
                        {{ $labels['save_invoice'] }}
                    </button>
                </div>

            </form>

        </div>

    </div>

    <script>
        $(document).ready(function() {

            $('#addRow').click(function() {

                let row = `
        <tr>

            <td>
                <input type="text" name="item_name[]" class="form-control" required>
            </td>

            <td>
                <input type="number" name="quantity[]" class="form-control qty" value="1">
            </td>

            <td>
                <input type="number" step="0.001" name="unit_price[]" class="form-control price">
            </td>

            <td>
                <input type="number" step="0.01" name="discount[]" class="form-control discount" value="0">
            </td>

            <td>
                <input type="number" step="0.01" name="tax[]" class="form-control tax" value="0">
            </td>

            <td>
                <input type="text" class="form-control line_total" readonly>
            </td>

            <td>
                <button type="button" class="btn btn-danger remove-row">
                    {{ $labels['remove'] }}
                </button>
            </td>

        </tr>
        `;

                $('#itemsTable tbody').append(row);
            });

            $(document).on('click', '.remove-row', function() {
                $(this).closest('tr').remove();
                calculateTotals();
            });

            $(document).on('keyup change', '.qty,.price,.discount,.tax', function() {
                calculateTotals();
            });

            function calculateTotals() {

                let subtotal = 0;
                let taxTotal = 0;
                let grandTotal = 0;

                $('#itemsTable tbody tr').each(function() {

                    let qty = parseFloat($(this).find('.qty').val()) || 0;
                    let price = parseFloat($(this).find('.price').val()) || 0;
                    let discount = parseFloat($(this).find('.discount').val()) || 0;
                    let tax = parseFloat($(this).find('.tax').val()) || 0;

                    let line = qty * price;

                    let discountAmount = line * (discount / 100);

                    let afterDiscount = line - discountAmount;

                    let taxAmount = afterDiscount * (tax / 100);

                    let total = afterDiscount + taxAmount;

                    $(this).find('.line_total').val(total.toFixed(3));

                    subtotal += afterDiscount;
                    taxTotal += taxAmount;
                    grandTotal += total;
                });

                $('#subtotal').text(subtotal.toFixed(3));
                $('#tax_total').text(taxTotal.toFixed(3));
                $('#grand_total').text(grandTotal.toFixed(3));
            }

        });
    </script>

</body>

</html>
