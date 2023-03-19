<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice_Attachment extends Model
{
    use HasFactory;
    protected $fillable=["invoice_id","name","invoice_number","user","add_date","due_date"];


    public function invoices(){


        return $this->belongsTo(invoice::class,'invoice_id');
    }
}
