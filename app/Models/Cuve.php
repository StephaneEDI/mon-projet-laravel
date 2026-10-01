<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/** Cuve identifiée par une lettre, avec sa capacité et le cépage qui y est affecté. */
class Cuve extends Model
{
    // Nom de la table
    protected $table = 'cuves';

    // Clé primaire personnalisée
    protected $primaryKey = 'Lettre_cuve';

    // Clé primaire de type texte (CHAR)
    public $incrementing = false;
    protected $keyType = 'string';

    // Désactiver les timestamps par défaut
    public $timestamps = false;

    // Colonnes autorisées
    protected $fillable = [
        'Lettre_cuve',
        'Capacite_cuve',
        'Nom_cepage',
    ];

    // Une cuve appartient à un cépage
    public function cepage()
    {
        return $this->belongsTo(Cepage::class, 'Nom_cepage', 'Nom_cepage');
    }
}