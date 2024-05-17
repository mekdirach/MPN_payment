<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class app_role extends Model
{
    protected $table = "app_role";
    protected $guarded = ['id'];

    use Notifiable;
}
