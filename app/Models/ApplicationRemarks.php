<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationRemarks extends Model
{
    use HasFactory;
    public $table = 'application_remarks';
    public $timestamps = false;
    protected $fillable = ['id','application_id','staff_id','rec_date','subject','notes','entry_at','service'];
}
