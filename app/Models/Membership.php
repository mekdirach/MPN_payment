<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Membership extends Model
{

    use Notifiable;

    protected $fillable = [
        'role',
        'contact_number',
        'biography'
    ];
}
