<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CriteriaList extends Model
{
    use HasFactory;
    public $table = 'criteria_list';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'rec_date',
        'criteria',
        'isDelete',
        'isActive'
    ];
}
