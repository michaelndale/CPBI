<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Elementfeb extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'febid ',
        'libellee',
        'montant'
        
    ];
}
