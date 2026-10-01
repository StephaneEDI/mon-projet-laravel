<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/** Étape planifiée d'une livraison de commande client, avec dates et statut de suivi. */
class LivraisonSuivie extends Model
{
    public const STATUTS = [
        'a_effectuer' => 'À effectuer',
        'en_cours' => 'En cours',
        'effectuee' => 'Effectuée',
        'annulee' => 'Annulée',
    ];

    protected $table = 'livraison_suivis';
    protected $primaryKey = 'Id_suivi';

    protected $fillable = [
        'Id_ligne',
        'Qte_prevue',
        'Date_prevue',
        'Statut',
        'Date_reelle',
    ];

    protected $casts = [
        'Date_prevue' => 'date',
        'Date_reelle' => 'date',
    ];

    public function ligne()
    {
        return $this->belongsTo(CommandeLigne::class, 'Id_ligne', 'Id_ligne');
    }
}