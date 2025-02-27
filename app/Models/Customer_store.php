<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer_store extends Model
{
    use SoftDeletes;

    protected $table='customer_stores';
    protected $primaryKey='id';
    protected $fillable = [
        'id', 
        'title', 
        'name',
        'gender',
        'phone_number',
        'image',
        'email',
        'created_at',
        'updated_at'
    ];

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y H:i:s');  // Custom format
    }
    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y H:i:s');  // Custom format
    }
}
