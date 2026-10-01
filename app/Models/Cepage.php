<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/** Référence les cépages vendus, leur stock, leur prix et leurs relations de production. */
class Cepage extends Model
{
    // Indiquer le nom exact de la table
    protected $table = 'cepages';

    // Définir la clé primaire personnalisée (Nom_cepage au lieu de id)
    protected $primaryKey = 'Nom_cepage';

    // Préciser que la clé primaire n'est pas un entier auto-incrémenté
    public $incrementing = false;
    protected $keyType = 'string';

    // Désactiver les colonnes timestamps par défaut (created_at / updated_at)
    public $timestamps = false;

    // Colonnes autorisées à la modification
    protected $fillable = [
        'Nom_cepage',
        'Couleur_cepage',
        'Teneur_suc_cepage',
        'Region_cepage',
        'Image_cepage',
        'Description_cepage',
        'Prix_kg_cepage',
        'Qte_cepage_disponible',
    ];

    // Une variété de cépage peut être stockée dans plusieurs cuves
    public function cuves()
    {
        return $this->hasMany(Cuve::class, 'Nom_cepage', 'Nom_cepage');
    }

    // Un cépage peut figurer sur plusieurs contrats
    public function contrats()
    {
        return $this->hasMany(Contrat::class, 'Nom_cepage', 'Nom_cepage');
    }
}