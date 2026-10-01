<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/** Livraison historique associée aux contrats via la table concerner. */
class Livraison extends Model
{
    // Nom de la table
    protected $table = 'livraisons';

    // Clé primaire
    protected $primaryKey = 'Num_livraison';

    // Desactiver l'auto-incrementation
    public $incrementing = false;

    // Desactiver les timestamps par defaut
    public $timestamps = false;

    // Colonnes autorisees
    protected $fillable = [
        'Num_livraison',
        'Date_reel_livraison',
    ];

    // Une livraison peut concerner plusieurs contrats
    public function contrats()
    {
        return $this->belongsToMany(Contrat::class, 'concerner', 'Num_livraison', 'Num_contrat')
                    ->withPivot('Qte_livree', 'Date_livree');
    }
}