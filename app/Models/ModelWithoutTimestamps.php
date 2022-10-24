<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CanGetTableNameStatically;

class ModelWithoutTimestamps extends Model
{
    use   CanGetTableNameStatically;

    // this can make vulnerability
    // protected $guarded = [];
    public $timestamps = false;
}
