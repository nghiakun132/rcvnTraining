<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mst_users extends Model
{
    use HasFactory;
    protected $table = 'mst_users';
    public $timestamps = false;
    protected $fillable = [
        'name',
        'email',
        'password',
        'group_role',
        'last_login_ip',
        'last_login_at',
        'created_at',
        'updated_at'
    ];
}
