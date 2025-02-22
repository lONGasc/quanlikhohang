<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $fillable = [
        'invoice_no',
        'supplier_id',
        'total_amount',
        'paid_amount',
        'due_amount',
    ];

    public function supplier()
    {
        return $this->belongsTo('App\Models\Supplier');
    }
   
    public function invoiceMeta()
    {
        return $this->hasMany('App\Models\InvoiceMeta');
    }
}
