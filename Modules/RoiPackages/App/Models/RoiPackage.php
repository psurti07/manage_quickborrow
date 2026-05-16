<?php

namespace Modules\RoiPackages\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\RoiPackages\Database\factories\RoiPackageFactory;

class RoiPackage extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    public $table = 'roipackages';
    protected $fillable = ['id','rec_date','bankid','roi','termsyears','termsmonths','isDelete'];

    protected static function newFactory(): RoiPackageFactory
    {
        //return RoiPackageFactory::new();
    }
}
