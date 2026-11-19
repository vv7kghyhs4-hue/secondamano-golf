<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/** Provincia italiana o Canton Ticino. */
class Province extends Model
{
    public $timestamps = false;

    protected $fillable = ['code', 'name', 'country', 'sort_order'];
}
