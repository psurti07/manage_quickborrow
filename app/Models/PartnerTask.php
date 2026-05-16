<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartnerTask extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'id', 'rce_date', 'assignees', 'assign_to', 'task_title', 'task_desc', 'attachment', 'priority', 'task_module', 'task_status', 'completion_date', 'remarks', 'project_name', 'isActive', 'isDelete'
    ];
}
