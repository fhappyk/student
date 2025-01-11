<?php

namespace App\Models;

use App\Models\StudentInfo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StudentCustomField extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'label', 'value'];

    public function student()
    {
        return $this->belongsTo(User::class, 'id', 'user_id');
    }
}
