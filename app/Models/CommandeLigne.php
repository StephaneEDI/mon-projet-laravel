<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/** Détaille un cépage, sa quantité et le prix retenu dans une commande. */
class CommandeLigne extends Model
{
    protected $table = 'commande_lignes';
    protected $primaryKey = 'Id_ligne';
    public $timestamps = false;

    protected $fillable = [
        'Id_commande',
        'Nom_cepage',
        'Quantite',
        'Prix_unitaire',
        'Sous_total',
    ];

    public function commande()
    {
        return $this->belongsTo(CommandeClient::class, 'Id_commande', 'Id_commande');
    }

    public function cepage()
    {
        return $this->belongsTo(Cepage::class, 'Nom_cepage', 'Nom_cepage');
    }

    public function livraisons()
    {
        return $this->hasMany(LivraisonSuivie::class, 'Id_ligne', 'Id_ligne');
    }
}