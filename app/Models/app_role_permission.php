<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class app_role_permission extends Model
{ //use HasFactory;
    use SoftDeletes;
    public $table = 'app_role_permission';


    protected $fillable = [
        'role_id',
        'permission_id',
        'table_id',
    ];
    //one to many
    public function permission()
    {
        return $this->belongsTo('App\Models\app_permission', 'permission_id', 'id');
    }

    public function role()
    {
        return $this->belongsTo('App\Models\app_role', 'role_id', 'id');
    }
}
