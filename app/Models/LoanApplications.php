<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanApplications extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'id','rec_date','userid','loan_amount','user_type','loan_type','monthly_income','cibilscore','loan_purpose','currentemi','emibounce','application_number','loantenure','status','isDelete'
    ];

    public function userRegistration()
    {
        return $this->belongsTo(UserRegistration::class);
    }
}
