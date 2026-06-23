<?php

use App\Http\Controllers\invoiceController;
use Illuminate\Support\Facades\Route;

use App\Models\Invoice;

Route::get('/', function () {

    $latestInvoice = Invoice::latest()->first();

    return view('home', compact('latestInvoice'));
});

Route::get('/create-invoice', [invoiceController::class, 'create'])->name('invoice.create');

Route::post('/invoice/store', [invoiceController::class, 'store'])->name('invoice.store');

Route::get('/invoices', [invoiceController::class, 'index'])->name('invoice.index');

Route::get('/invoice/{id}/preview', [invoiceController::class, 'preview'])->name('invoice.preview');

Route::get('/invoice/{id}/pdf', [invoiceController::class, 'pdf'])->name('invoice.pdf');
