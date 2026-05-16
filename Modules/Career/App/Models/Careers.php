<?php

namespace Modules\Career\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Career\Database\factories\CareersFactory;

class Careers extends Model
{
    use HasFactory;
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['id',
        'rec_date',
        'title',
        'descriptions',
        'slug',
        'isActive',
        'isDelete'];

    protected static function newFactory(): CareersFactory
    {
        //return CareersFactory::new();
    }
}
