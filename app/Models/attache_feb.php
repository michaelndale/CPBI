<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class attache_feb extends Model
{
    use HasFactory;
    protected $fillable = 
    [
        'febid', 
        'annexid'
    ]; 
}
