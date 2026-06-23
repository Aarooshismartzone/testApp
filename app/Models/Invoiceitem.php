<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoiceitem extends Model
{
    protected $table = 'invoiceitems';

    protected $fillable = [
        'invoice_id',
        'item_name',
        'quantity',
        'unit_price',
        'discount_percent',
        'tax_percent',
        'line_total'
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }
}