<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Speciality extends Model
{
    protected $fillable = [
        'title',
        'type',
        'parent_id'
    ];

    // Relationship to parent speciality
    public function parent()
    {
        return $this->belongsTo(__CLASS__, 'parent_id', 'id');
    }

    // Relationship to children specialities
    public function children()
    {
        return $this->hasMany(__CLASS__, 'parent_id', 'id');
    }

    // Scope to get parent specialities (where parent_id is null)
    public function scopeParents($query)
    {
        return $query->whereNull('parent_id');
    }

    // Scope to get child specialities (where parent_id is not null)
    public function scopeChildrens($query)
    {
        return $query->whereNotNull('parent_id');
    }
}

