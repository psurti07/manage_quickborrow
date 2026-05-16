<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adscontent extends Model
{
    use HasFactory;
    public $table = 'adscontent';
    public $timestamps = false;
    protected $fillable = [
        'id', 'rec_date','ad_type', 'ad_content', 'isDelete'
    ];
}
