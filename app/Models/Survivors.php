<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Survivors extends Model
{
	protected $table = 'survivors';
    protected $fillable = [
        'name',
        'age',
        'gender',
        'lat',
        'lng',
        'water',
        'food',
        'medication',
        'ammunition'
    ];
}
