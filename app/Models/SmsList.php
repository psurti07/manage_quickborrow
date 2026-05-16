<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsList extends Model
{
    use HasFactory;
    public $table = 'sms_list';
    public $timestamps = false;
    protected $fillable = ['id','rec_date','type','title','message','isActive'];

}
