<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feb extends Model
{
    use HasFactory;
    protected $fillable = ['numerofeb','activityid','periode','datefeb'];
}
