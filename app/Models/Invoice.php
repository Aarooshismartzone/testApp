<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'customer_id',
        'invoice_number',
        'subtotal',
        'discount_total',
        'tax_total',
        'grand_total',
        'notes'
    ];

    public function items()
    {
        return $this->hasMany(Invoiceitem::class, 'invoice_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}