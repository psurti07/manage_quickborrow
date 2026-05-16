<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplylinkWithCriteria extends Model
{
    use HasFactory;
    public $table = 'applylink_criteria';
    public $timestamps = false;

    protected $fillable = ['id','rec_date','applylink_id','criteria_id'];
}
