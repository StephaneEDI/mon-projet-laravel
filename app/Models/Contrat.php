<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/** Contrat d'approvisionnement associé à un négociant et éventuellement à un cépage. */
class Contrat extends Model
{
    // Nom de la table
    protected $table = 'contrats';

    // Clé primaire
    protected $primaryKey = 'Num_contrat';

    // Désactiver l'auto-incrémentation si tu gères manuellement les numéros
    public $incrementing = false;

    // Désactiver les timestamps par défaut
    public $timestamps = false;

    // Colonnes autorisées
    protected $fillable = [
        'Num_contrat',
        'Date_contrat',
        'Qte_commande',
        'Date_echeance_contrat',
        'Id_negociant',
        'Id_utilisateur',
        'Nom_cepage',
        'Date_modification',
    ];

    // Un contrat appartient à un négociant
    public function negociant()
    {
        return $this->belongsTo(Negociant::class, 'Id_negociant', 'Id_negociant');
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'Id_utilisateur', 'Id_utilisateur');
    }

    // Un contrat concerne un cépage
    public function cepage()
    {
        return $this->belongsTo(Cepage::class, 'Nom_cepage', 'Nom_cepage');
    }

    // Un contrat peut être lié à plusieurs livraisons via la table concerner
    public function livraisons()
    {
        return $this->belongsToMany(Livraison::class, 'concerner', 'Num_contrat', 'Num_livraison')
                    ->withPivot('Qte_livree', 'Date_livree');
    }
}