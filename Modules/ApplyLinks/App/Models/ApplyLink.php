<?php

namespace Modules\ApplyLinks\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\ApplyLinks\Database\factories\ApplyLinkFactory;
use Modules\Banks\App\Models\Banks;

class ApplyLink extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    public $table =  'bankapplylink';
    public $timestamps =  false;
    protected $fillable = ['id','rec_date','bankid','title','applyurl','roi','tenures','status_type','option1','option2','option3','option4','option5','is_recommended','isDelete'];

    protected static function newFactory(): ApplyLinkFactory
    {
        //return ApplyLinkFactory::new();
    }
    
    public function bank(){
        return $this->belongsTo(Banks::class,'bankid', 'id');
    }
}
