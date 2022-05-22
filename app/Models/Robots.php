<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Robots extends Model
{
	protected $table = 'robots';
    protected $fillable = [
        'model',
        'serialNumber',
        'manufacturedDate',
        'category'
    ];
}
