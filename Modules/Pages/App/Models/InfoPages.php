<?php

namespace Modules\Pages\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Pages\Database\factories\InfoPagesFactory;

class InfoPages extends Model
{
    use HasFactory;
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['id','slug','content','rec_date'];

    protected static function newFactory(): InfoPagesFactory
    {
        //return InfoPagesFactory::new();
    }
}
