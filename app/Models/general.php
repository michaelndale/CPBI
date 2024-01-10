<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class general extends Model
{
    use HasFactory;
    protected $fillable = ['namesite','adresse','email'];
}
