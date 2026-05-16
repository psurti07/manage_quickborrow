<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtpVerification extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['id','rec_date','mobile','email','otp'];
}
