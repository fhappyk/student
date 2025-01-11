<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'phone',
        'country',
        'region',
        'city',
        'address',
        'lattitude',
        'longitude',
        'professional_email',
        'professional_phone',
        'department',
        'speciality_area',
        'speciality',
        'registration_date',
        'title',
        'years_of_experience',
        'other_phone',
        'other_email',
        'speciality_area',
        'image',
        'office_name',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
