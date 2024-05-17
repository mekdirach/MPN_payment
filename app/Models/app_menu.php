<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class app_menu extends Model
{
    //use HasFactory;
    use SoftDeletes;
    public $table = 'app_menu';
    protected $dates = [
        'created_by',
        'updated_by',
        'updated_at',
        'created_at',
    ];

    protected $fillable = [
        'is_active',
        'table_id',
        'parent_id',
        'path',
        'fa_icon',
        'position',
        'show',
        'description',
        'mod_prefix',
        'created_by',
        'updated_by',
        'updated_at',
        'created_at',
    ];
}
