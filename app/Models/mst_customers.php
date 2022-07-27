<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mst_customers extends Model
{
    use HasFactory;
    protected $table = 'mst_customers';
    protected $primaryKey = 'customer_id';
    public $timestamps = false;
    protected $fillable = [
        'customer_id',
        'customer_name',
        'email',
        'tel_num',
        'address',
        'is_active',
        'created_at',
        'updated_at',
    ];
}
