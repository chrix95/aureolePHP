<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'name',
        'isbn',
        'authors',
        'country',
        'number_of_pages',
        'publisher',
        'release_date'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function setAuthorsAttribute($value) {
        $this->attributes['authors'] = serialize($value);
    }

    public function getAuthorsAttribute($value) {
        return unserialize($value);
    }

    public function scopeDate($query, $date) {
        return $query->where('release_date', 'LIKE', '%' . $date . '%');
    }

}
