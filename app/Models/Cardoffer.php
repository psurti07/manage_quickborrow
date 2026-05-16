<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cardoffer extends Model
{
    use HasFactory;
    public $table = 'cardoffer';
    public $timestamps = false;
    protected $fillable = ['id','rec_date','user_id','offerpage','first_name','last_name','mobile','emailid','card_number','registration_date','expiry_date','amount','paymentid','isCustomer','isActive','isDelete'];
}
