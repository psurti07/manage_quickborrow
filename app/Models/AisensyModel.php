<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AisensyModel extends Model
{
    use HasFactory;
    
    public $table = 'aisensy_settings';
    public $timestamps = false;
    
    protected $fillable = ['id','rec_date','product','type','api_key','campaign_name','media_url','media_filename'];
}
