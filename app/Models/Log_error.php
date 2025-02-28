<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Log_error extends Model
{
    use SoftDeletes;

    protected $table='log_fail';
    protected $primaryKey='id';
    protected $fillable = [
        'id', 
        'path',
        'error_msg',
        'created_at',
        'updated_at'
    ];
    
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->timezone('Asia/Jakarta')->format('d-m-Y H:i:s');  // Custom format
    }
    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->timezone('Asia/Jakarta')->format('d-m-Y H:i:s');  // Custom format
    }
}
