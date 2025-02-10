<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Securite extends Model
{
    use HasFactory;

    // Autoriser les attributs suivants pour l'affectation massive
    protected $fillable = [
        'project_id',
        'exercice_id',
        'code',
        'statut', // Remplacez par 'status_exe' si nécessaire
    ];
}
