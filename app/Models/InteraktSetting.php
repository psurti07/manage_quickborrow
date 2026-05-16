<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InteraktSetting extends Model
{
    use HasFactory;
    
    public $table = 'interakt_settings';
    public $timestamps = false;
    
    protected $fillable = ['id','rec_date','product','type','template_name','img_url','api_key'];
}
