<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/** Gère l'inscription client, la connexion par courriel et la déconnexion web. */
class AuthController extends Controller
{
    // Afficher le formulaire de connexion
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Traiter la connexion
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'Email_utilisateur' => ['required', 'email'],
            'Password_utilisateur' => ['required'],
        ]);

        $user = User::where('Email_utilisateur', $request->Email_utilisateur)->first();

        if ($user && Hash::check($request->Password_utilisateur, $user->Password_utilisateur)) {
            Auth::login($user);
            $request->session()->regenerate();

            // Redirection selon le rôle
            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->intended(route('home'))->with('success', 'Ravi de vous revoir !');
        }

        return back()->withErrors([
            'Email_utilisateur' => 'Les identifiants ne correspondent pas à nos enregistrements.',
        ]);
    }

    // Afficher le formulaire d'inscription
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Traiter l'inscription client
    public function register(Request $request)
    {
        $request->validate([
            'Nom_utilisateur' => 'required|string|max:100',
            'Prenom_utilisateur' => 'required|string|max:100',
            'Email_utilisateur' => 'required|email|unique:utilisateurs,Email_utilisateur',
            'Password_utilisateur' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'Nom_utilisateur' => $request->Nom_utilisateur,
            'Prenom_utilisateur' => $request->Prenom_utilisateur,
            'Email_utilisateur' => $request->Email_utilisateur,
            'Password_utilisateur' => Hash::make($request->Password_utilisateur),
            'Role_utilisateur' => 'negociant', // Rôle client / négociant par défaut
            'Telephone_utilisateur' => $request->Telephone_utilisateur,
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->intended(route('home'))->with('success', 'Votre compte a été créé avec succès !');
    }

    // Déconnexion
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}