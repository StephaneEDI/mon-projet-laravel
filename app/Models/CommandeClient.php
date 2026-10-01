<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/** En-tête d'une demande passée par un compte client depuis le panier. */
class CommandeClient extends Model
{
    public const STATUTS = [
        'En attente',
        'Confirmée',
        'En préparation',
        'Expédiée',
        'Livrée',
        'Annulée',
    ];

    protected $table = 'commandes';
    protected $primaryKey = 'Id_commande';

    protected $fillable = [
        'Id_utilisateur',
        'Montant_total',
        'Statut_commande',
    ];

    public function client()
    {
        return $this->belongsTo(User::class, 'Id_utilisateur', 'Id_utilisateur');
    }

    public function lignes()
    {
        return $this->hasMany(CommandeLigne::class, 'Id_commande', 'Id_commande');
    }
}