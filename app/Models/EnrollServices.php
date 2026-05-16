<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnrollServices extends Model
{
    use HasFactory;
    public $table = 'enroll_services';
    public $timestamps = false;
    protected $fillable = ['id','rec_date','serviceid','purchase_date','valid_upto','amount','paymentid'];
}
