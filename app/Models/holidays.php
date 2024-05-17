<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class holidays extends Model
{
    protected $table = "holidays";
    protected $primaryKey = 'id';

    use Notifiable;
}
