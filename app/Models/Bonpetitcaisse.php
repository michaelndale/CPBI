<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bonpetitcaisse extends Model
{
    use HasFactory;
    protected $fillable = ['projetid', 'numero', 'userid', 'date', 'motif','nom_prenom_sous_signe','lignedecaisse', 'telephone_email','signe_beneficiaire','distributaire'];
}
