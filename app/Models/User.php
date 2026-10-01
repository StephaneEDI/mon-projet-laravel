<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/** Compte authentifiable stocké dans utilisateurs; les inscriptions publiques créent des négociants. */
class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'utilisateurs';
    protected $primaryKey = 'Id_utilisateur';
    public $timestamps = false;

    protected $fillable = [
        'Id_utilisateur',
        'Nom_utilisateur',
        'Prenom_utilisateur',
        'Email_utilisateur',
        'Password_utilisateur',
        'Role_utilisateur',
        'Telephone_utilisateur',
        'Photo_utilisateur',
    ];

    protected $hidden = [
        'Password_utilisateur',
    ];

    // Indique à Laravel le nom exact de la colonne du mot de passe
    public function getAuthPassword()
    {
        return $this->Password_utilisateur;
    }

   // app/Models/User.php

/**
 * Vérifie si l'utilisateur possède le rôle administrateur.
 */
public function isAdmin(): bool
{
    // Adaptation au champ 'Role_utilisateur' de ta table BDD
    return strtolower($this->Role_utilisateur) === 'admin';
}
}