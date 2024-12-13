<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Revision extends Model
{
    use HasFactory;

    // Définir le nom de la table si elle n'est pas au pluriel
    protected $table = 'revisions';

    // Définir les colonnes qui peuvent être assignées en masse
    protected $fillable = [
        'projet_id', 
        'ancien_montant', 
        'nouveau_montant', 
        'description',
        'user_id'
    ];


    public function project()
    {
        return $this->belongsTo(Project::class, 'projet_id');
    }
}
