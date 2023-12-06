<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VPNModel extends Model
{
    use HasFactory;
    protected $table = 'user';
    protected $guard = [];
    public $timestamps = false;
}
