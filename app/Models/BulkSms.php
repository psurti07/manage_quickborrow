<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BulkSms extends Model
{
    use HasFactory;
    public $table = 'bulksms';
    public $timestamps = false;
    protected $fillable = ['id','rec_date','fullname','email','mobile'];
}
