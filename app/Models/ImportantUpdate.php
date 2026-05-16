<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportantUpdate extends Model
{
    use HasFactory;
    public $table = 'important_update';
    public $timestamps = false;

    protected $fillable = ['id','rec_date','tags','descriptions','isActive','isDelete'];
}
