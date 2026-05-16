<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanApplicationStatus extends Model
{
    use HasFactory;
    public $table = 'loan_application_status';
    public $timestamps = false;
    protected $fillable = [
        'id', 'rec_date','applicationid','statusdate','statusid','bankid','loanamount','loanroi','loanterms','processfees','insurance','monthlyemi','remarks','sanction_letter','staffid','isDelete'
    ];
}
