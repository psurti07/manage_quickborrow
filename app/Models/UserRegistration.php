<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class UserRegistration extends Authenticatable
{
    use HasFactory;
    public $table = 'user_registrations';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'rec_date',
        'offerpage',
        'staff_id',
        'update_date',
        'first_name',
        'last_name',
        'mobile',
        'email',
        'password',
        'dob',
        'pancard',
        'city',
        'state',
        'refcode',
        'process_step',
        'pincode',
        'isUser',
        'acc_type',
        'company_name',
        'company_gst',
        'iAgree',
        'isDelete',
        'isDnd',
        'isVerified',
        'isActive'
    ];

    public function loanApplications(){
        return $this->hasMany(LoanApplications::class,'userid');
    }
}
