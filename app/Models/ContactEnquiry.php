<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class ContactEnquiry extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table ='contact_enquiry';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'rec_date',
        'fullname',
        'mobile',
        'email',
        'subject',
        'message',
        'server_ip'];
}
