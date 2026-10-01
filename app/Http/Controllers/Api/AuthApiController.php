<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/** Fournit les points d'entrée API pour créer un compte et gérer un jeton client. */
class AuthApiController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'Nom_utilisateur' => 'required|string|max:100',
            'Prenom_utilisateur' => 'required|string|max:100',
            'Email_utilisateur' => 'required|email|unique:utilisateurs,Email_utilisateur',
            'Password_utilisateur' => 'required|min:6',
        ]);

        $maxId = User::max('Id_utilisateur') ?? 0;

        $user = User::create([
            'Id_utilisateur' => $maxId + 1,
            'Nom_utilisateur' => $request->Nom_utilisateur,
            'Prenom_utilisateur' => $request->Prenom_utilisateur,
            'Email_utilisateur' => $request->Email_utilisateur,
            'Password_utilisateur' => Hash::make($request->Password_utilisateur),
            'Role_utilisateur' => 'negociant',
            'Telephone_utilisateur' => $request->Telephone_utilisateur,
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Compte créé avec succès !',
            'token' => $token,
            'user' => $user
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'Email_utilisateur' => 'required|email',
            'Password_utilisateur' => 'required',
        ]);

        $user = User::where('Email_utilisateur', $request->Email_utilisateur)->first();

        if (!$user || !Hash::check($request->Password_utilisateur, $user->Password_utilisateur)) {
            return response()->json(['message' => 'Identifiants incorrects.'], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Connexion réussie',
            'token' => $token,
            'role' => $user->Role_utilisateur,
            'user' => $user
        ]);
    }

    public function profil(Request $request)
    {
        return response()->json($request->user());
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Déconnexion réussie.']);
    }
}