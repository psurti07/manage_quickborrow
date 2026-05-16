<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Auth\App\Models\Administrations;

class SupportRequestChat extends Model
{
    use HasFactory;
    public $timestamps = false;
    public $table = 'support_request_chat';
    protected $fillable = ['id','rec_date','requestid','remarks','staffid','isDelete'];

    public function staff() {
        return $this->belongsTo(Administrations::class, 'staffid'); // 'staffid' is the foreign key in support_request_chat table
    }
}

