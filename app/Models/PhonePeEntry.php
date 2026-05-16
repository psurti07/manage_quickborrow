<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhonePeEntry extends Model
{
    use HasFactory;
    public $table = 'phonepe_entry';
    public $timestamps = false;

    protected $fillable = ['id','rec_date','entryfor','userid','orderid','orderamount','ordernote','referenceid','txstatus','paymentmode'];
}
