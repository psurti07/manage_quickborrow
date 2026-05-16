<?php

namespace Modules\CompanyLeads\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\CompanyLeads\Database\factories\MembershipOrderFactory;

class MembershipOrder extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    public $table = 'membership_orders';
    public $timestamps = false;
    protected $fillable = ['id','rec_date','userid','registration_date','expiry_date','card_number','amount','paymentid','isActive','isDelete'];

    protected static function newFactory(): MembershipOrderFactory
    {
        //return MembershipOrderFactory::new();
    }
}
