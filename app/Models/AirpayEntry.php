<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AirpayEntry extends Model
{
    use HasFactory;
    public $table = 'airpay_entry';
    public $timestamps = false;
    protected $fillable = ['id', 'rec_date', 'entryfor', 'userid', 'orderid', 'orderamount', 'ordernote', 'transactionid', 'statuscode', 'paymentmode'];
}
