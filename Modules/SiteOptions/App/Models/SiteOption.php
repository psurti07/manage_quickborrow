<?php

namespace Modules\SiteOptions\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\SiteOptions\Database\factories\SiteOptionFactory;

class SiteOption extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    public $timestamps = false;
    protected $fillable = ['id','rec_date','option_key','option_value'];

    protected static function newFactory(): SiteOptionFactory
    {
        //return SiteOptionFactory::new();
    }
}
