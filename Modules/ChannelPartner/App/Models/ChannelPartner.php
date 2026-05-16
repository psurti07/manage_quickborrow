<?php

namespace Modules\ChannelPartner\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\ChannelPartner\Database\factories\ChannelPartnerFactory;

class ChannelPartner extends Model
{
    use HasFactory;
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     */

    protected $fillable = ['id','rec_date','first_name','last_name','mobile','email','password','company_code','company_name','vat_gst_no','phone','website','address','city','state','pincode','country','isActive','isDelete'];

    protected static function newFactory(): ChannelPartnerFactory
    {
        //return ChannelPartnerFactory::new();
    }
}
