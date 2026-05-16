<?php

namespace Modules\Invoice\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Invoice\Database\factories\InvoiceFactory;

class Invoice extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    public $timestamps = false;
    protected $fillable = ['id','rec_date','cardid','userid','inv_prefix','inv_number','inv_date','inv_price','inv_cgst','inv_sgst','inv_igst','inv_grandtotal','remarks','isdelete'];

    protected static function newFactory(): InvoiceFactory
    {
        //return InvoiceFactory::new();
    }
}
