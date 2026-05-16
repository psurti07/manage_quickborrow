<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VeegahPay extends Model
{
    use HasFactory;
    public $table = 'vegaah_entry';
    public $timestamps = false;
    protected $fillable = [
        'id', 'rec_date', 'entryfor', 'userid', 'orderid', 'orderamount', 'ordernote', 'referenceid', 'txstatus', 'paymentmode'
    ];
}
