<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTree extends Model
{
    use HasFactory;
    public $table = 'user_tree';
    public $timestamps = false;
    protected $fillable = [
        'id','rec_date','refferaltype','refferaluserid','subuserid','payout','payout_date','payout_amount','order_amount'
    ];
}
