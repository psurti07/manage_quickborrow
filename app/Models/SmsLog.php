<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsLog extends Model
{
    use HasFactory;
    public $table = 'sms_log';
    public $timestamps = false;
    protected $fillable = ['id','rec_date','crontype','parentid','cronname','msgcount','msgresponse'];
}
