<?php

namespace Modules\Inhouse\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Inhouse\Database\factories\StaffTaskFactory;

class StaffTask extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['id','rec_date','assignee_id','follower_id','task_title','task_desc','attachment','priority','task_module','task_status','completion_date','remarks','projects','task_goal','isActive','isDelete'];

    protected static function newFactory(): StaffTaskFactory
    {
        //return StaffTaskFactory::new();
    }
}
