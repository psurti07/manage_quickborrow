<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZaakpayEntry extends Model
{
    use HasFactory;
    public $table = 'zaakpay_entry';
    public $timestamps = false;

    protected $fillable = ['id','rec_date','entryfor','userid','orderid','orderamount','ordernote','statuscode','transactionid','paymentmode'];
}
