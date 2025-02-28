<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Address_store extends Model
{
    use SoftDeletes;

    protected $table='address_stores';
    protected $primaryKey='id';
    protected $fillable = [
        'id', 
        'customer_id', 
        'address',
        'district',
        'city',
        'province',
        'postal_code',
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
