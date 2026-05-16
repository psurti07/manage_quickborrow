<?php

namespace Modules\Career\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Career\Database\factories\CareerEnquiryFactory;

class CareerEnquiry extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    public $timestamps = false;
    protected $fillable = [
        'id',
        'rec_date',
        'firstname',
        'lastname',
        'mobile',
        'email',
        'applyfor',
        'resume',
        'qualifications',
        'experience',
        'city',
        'keyskills',
        'serverip',
        'isDelete' ];

    protected static function newFactory(): CareerEnquiryFactory
    {
        //return CareerEnquiryFactory::new();
    }
}
