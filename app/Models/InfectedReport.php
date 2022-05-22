<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InfectedReport extends Model
{
	protected $table = 'infected_report';
    protected $fillable = [
        'report_by',
        'survivor_id',
        'flag',
    ];
}
