<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SourceEntry extends Model
{
    use HasFactory;
    protected $table = 'source_entry';
    public $timestamps = false;
    
    protected $fillable = [
        'id','rec_date','user_id','utm_source','utm_campaign','utm_medium','source_id','utm_referral','client_ip'    
    ];
}
