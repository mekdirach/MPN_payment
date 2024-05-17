<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class app_role_menu extends Model
{
    use SoftDeletes;
    public $table = 'app_role_menu';


    protected $fillable = [
        'role_id',
        'menu_id',
        'table_id',
    ];
    //one to many
    public function menu()
    {
        return $this->belongsTo('App\Models\app_menu', 'menu_id', 'id');
    }

    public function role()
    {
        return $this->belongsTo('App\Models\app_role', 'role_id', 'id');
    }
}
