<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportRequests extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['id','rec_date','ticketno','usertype','firstname','lastname','mobile','email','issuetype','cardnumber','message','status','serverip','isDelete'];
}
