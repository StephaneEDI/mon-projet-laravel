<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/** Table pivot de l'historique reliant un contrat à une livraison effectuée. */
class Concerner extends Model
{
    // Nom de la table
    protected $table = 'concerner';

    // Clé primaire
    protected $primaryKey = 'numero';

    // Désactiver les timestamps par défaut
    public $timestamps = false;

    // Colonnes autorisées à la modification
    protected $fillable = [
        'Num_contrat',
        'Num_livraison',
        'Qte_livree',
        'Date_livree',
    ];

    // Relation vers le contrat
    public function contrat()
    {
        return $this->belongsTo(Contrat::class, 'Num_contrat', 'Num_contrat');
    }

    // Relation vers la livraison
    public function livraison()
    {
        return $this->belongsTo(Livraison::class, 'Num_livraison', 'Num_livraison');
    }
}