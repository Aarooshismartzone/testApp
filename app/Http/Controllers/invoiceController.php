<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Invoiceitem;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class invoiceController extends Controller
{
    /**
     * Show Create Invoice Page
     */
    public function create()
    {
        $customers = Customer::orderBy('name')->get();

        return view('create-invoice', compact('customers'));
    }

    /**
     * Save Invoice
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'item_name'   => 'required|array|min:1',
            'quantity'    => 'required|array',
            'unit_price'  => 'required|array',
            'discount'    => 'required|array',
            'tax'         => 'required|array',
        ]);

        DB::beginTransaction();

        try {

            $subtotal = 0;
            $discountTotal = 0;
            $taxTotal = 0;
            $grandTotal = 0;

            /*
            |--------------------------------------------------------------------------
            | First Loop
            | Calculate all totals server-side
            |--------------------------------------------------------------------------
            */

            foreach ($request->item_name as $index => $itemName) {

                $qty = (float) ($request->quantity[$index] ?? 0);
                $price = (float) ($request->unit_price[$index] ?? 0);
                $discountPercent = (float) ($request->discount[$index] ?? 0);
                $taxPercent = (float) ($request->tax[$index] ?? 0);

                $lineAmount = $qty * $price;

                $discountAmount = $lineAmount * ($discountPercent / 100);

                $afterDiscount = $lineAmount - $discountAmount;

                $taxAmount = $afterDiscount * ($taxPercent / 100);

                $lineTotal = $afterDiscount + $taxAmount;

                $subtotal += $lineAmount;
                $discountTotal += $discountAmount;
                $taxTotal += $taxAmount;
                $grandTotal += $lineTotal;
            }

            /*
            |--------------------------------------------------------------------------
            | Create Invoice
            |--------------------------------------------------------------------------
            */
            $invoiceNumber =
                'INV-' .
                str_pad(
                    Invoice::count() + 1,
                    5,
                    '0',
                    STR_PAD_LEFT
                );

            $invoice = Invoice::create([
                'customer_id'    => $request->customer_id,
                'invoice_number' => $invoiceNumber,
                'subtotal'       => $subtotal,
                'discount_total' => $discountTotal,
                'tax_total'      => $taxTotal,
                'grand_total'    => $grandTotal,
                'notes'          => null,
            ]);

            /*
            |--------------------------------------------------------------------------
            | Save Invoice Items
            |--------------------------------------------------------------------------
            */

            foreach ($request->item_name as $index => $itemName) {

                $qty = (float) ($request->quantity[$index] ?? 0);
                $price = (float) ($request->unit_price[$index] ?? 0);
                $discountPercent = (float) ($request->discount[$index] ?? 0);
                $taxPercent = (float) ($request->tax[$index] ?? 0);

                $lineAmount = $qty * $price;

                $discountAmount = $lineAmount * ($discountPercent / 100);

                $afterDiscount = $lineAmount - $discountAmount;

                $taxAmount = $afterDiscount * ($taxPercent / 100);

                $lineTotal = $afterDiscount + $taxAmount;

                Invoiceitem::create([
                    'invoice_id'       => $invoice->id,
                    'item_name'        => $itemName,
                    'quantity'         => $qty,
                    'unit_price'       => $price,
                    'discount_percent' => $discountPercent,
                    'tax_percent'      => $taxPercent,
                    'line_total'       => $lineTotal,
                ]);
            }

            DB::commit();

            return redirect()
                ->route('invoice.preview', $invoice->id)
                ->with('success', 'Invoice created successfully');
        } catch (\Exception $e) {

            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    public function preview($id)
    {
        $invoice = Invoice::with(['customer', 'items'])
            ->findOrFail($id);

        return view('invoice-preview', compact('invoice'));
    }

    public function pdf($id)
    {
        $invoice = Invoice::with(['customer', 'items'])
            ->findOrFail($id);

        $pdf = Pdf::loadView('invoice-pdf', compact('invoice'));

        return $pdf->stream(
            $invoice->invoice_number . '.pdf'
        );
    }

    public function index()
{
    $invoices = Invoice::with('customer')
        ->latest()
        ->get();

    return view('all-invoices', compact('invoices'));
}
}
