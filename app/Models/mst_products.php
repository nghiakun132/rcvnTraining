<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mst_products extends Model
{
    use HasFactory;
    protected $table = 'mst_products';
    protected $primaryKey = 'product_id';
    protected $keyType = 'string';
    public $timestamps = false;
    protected $fillable = [
        'product_id',
        'product_name',
        'product_price',
        'product_image',
        'description',
        'product_status',
        'created_at',
        'updated_at'
    ];
}
