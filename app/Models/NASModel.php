<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NASModel extends Model
{
    use HasFactory;
    protected $table = 'nas';
    protected $guard = [];
}
