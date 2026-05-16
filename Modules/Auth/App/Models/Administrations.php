<?php

namespace Modules\Auth\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Modules\Auth\Database\factories\AdministrationsFactory;

class Administrations extends Authenticatable
{
    use HasFactory;
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['id','rec_date','fullname','mobile','emailid','password','staff_code','role','isActive','isDelete'];

    protected static function newFactory(): AdministrationsFactory
    {
        //return AdministrationsFactory::new();
    }
}
