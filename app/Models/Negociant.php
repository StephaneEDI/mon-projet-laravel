<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/** Coordonnées d'un négociant indépendant référencé dans les contrats. */
class Negociant extends Model
{
    // Nom de la table
    protected $table = 'negociants';

    // Clé primaire personnalisée
    protected $primaryKey = 'Id_negociant';

    // Si l'ID n'est pas auto-incrémenté par la BDD
    public $incrementing = false;

    // Désactiver les colonnes timestamps de Laravel
    public $timestamps = false;

    // Colonnes autorisées
    protected $fillable = [
        'Id_negociant',
        'Nom_negociant',
        'Prenom_negociant',
        'Telephone_negociant',
    ];

    // Un négociant peut avoir plusieurs contrats
    public function contrats()
    {
        return $this->hasMany(Contrat::class, 'Id_negociant', 'Id_negociant');
    }
}