<?php

namespace Modules\Banks\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Banks\Database\factories\BanksFactory;
use Modules\ApplyLinks\App\Models\ApplyLink;

class Banks extends Model
{
    use HasFactory;
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['id','rec_date','bank_name','bank_image','order_no','isDelete'];

    protected static function newFactory(): BanksFactory
    {
        //return BanksFactory::new();
    }
    
    public function applylinks(){
        return $this->hasOne(ApplyLink::class,'bankid','id');
    }
}
