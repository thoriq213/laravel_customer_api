<?php

namespace App\Models;

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
}
