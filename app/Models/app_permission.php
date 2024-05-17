<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class app_permission extends Model
{
    //use HasFactory;
    use SoftDeletes;
    public $table = 'app_permission';
    protected $dates = [
        'created_by',
        'updated_by',
        'updated_at',
        'created_at',
    ];

    protected $fillable = [
        'is_active',
        'name',
        'table_id',
        'parent_id',
        'path',
        'menu_id',
        'type',
        'nama_external',
        'created_by',
        'updated_by',
        'updated_at',
        'created_at',
    ];
}
