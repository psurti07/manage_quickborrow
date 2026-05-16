<?php

namespace Modules\Remarks\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Banks\Database\factories\BanksFactory;

class Remark extends Model
{
    use HasFactory;
    protected $table = 'loanstatus_remarks';
    public $timestamps = false;

    protected $fillable = ['id','rec_date','title','remarks','statusid','isDelete'];

    

}
