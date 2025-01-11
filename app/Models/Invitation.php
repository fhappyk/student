<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{

    protected $fillable = [
        'uuid',
        'email',
        'status',
        'name',
    ];
}
