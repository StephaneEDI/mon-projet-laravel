<?php

namespace App\Http\Controllers;

use App\Models\Contrat;
use App\Models\Cepage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/** Gère les contrats producteurs enregistrés dans la table contrats. */
class ContratController extends Controller
{
    public function index()
    {
        $contrats = Contrat::with(['negociant', 'client'])->get();
        return view('contrats.index', compact('contrats'));
    }

    public function create()
    {
        $negociants = User::where('Role_utilisateur', 'negociant')
            ->orderBy('Nom_utilisateur')
            ->orderBy('Prenom_utilisateur')
            ->get();
        $cepages = Cepage::all();
        return view('contrats.create', compact('negociants', 'cepages'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'Num_contrat' => ['required', 'integer', 'min:1', 'unique:contrats,Num_contrat'],
            'Date_contrat' => ['required', 'date'],
            'Date_echeance_contrat' => ['required', 'date', 'after_or_equal:Date_contrat'],
            'Qte_commande' => ['required', 'numeric', 'gt:0'],
            'Id_utilisateur' => [
                'required',
                'integer',
                Rule::exists('utilisateurs', 'Id_utilisateur')->where('Role_utilisateur', 'negociant'),
            ],
            'Nom_cepage' => ['nullable', 'string', 'exists:cepages,Nom_cepage'],
        ]);

        Contrat::create($validated);

        return redirect()->route('contrats.index')->with('success', 'Contrat créé avec succès !');
    }

    public function edit(string $id)
    {
        $contrat = Contrat::findOrFail($id);
        $negociants = User::where('Role_utilisateur', 'negociant')
            ->orderBy('Nom_utilisateur')
            ->orderBy('Prenom_utilisateur')
            ->get();
        $cepages = Cepage::all();
        return view('contrats.edit', compact('contrat', 'negociants', 'cepages'));
    }

    public function update(Request $request, string $id)
    {
        $contrat = Contrat::findOrFail($id);

        $validated = $request->validate([
            'Date_contrat' => ['required', 'date'],
            'Date_echeance_contrat' => ['required', 'date', 'after_or_equal:Date_contrat'],
            'Qte_commande' => ['required', 'numeric', 'gt:0'],
            'Id_utilisateur' => [
                'required',
                'integer',
                Rule::exists('utilisateurs', 'Id_utilisateur')->where('Role_utilisateur', 'negociant'),
            ],
            'Nom_cepage' => ['nullable', 'string', 'exists:cepages,Nom_cepage'],
        ]);

        $contrat->update($validated);

        return redirect()->route('contrats.index')->with('success', 'Contrat mis à jour !');
    }

    public function destroy(string $id)
    {
        $contrat = Contrat::findOrFail($id);
        $contrat->delete();

        return redirect()->route('contrats.index')->with('success', 'Contrat supprimé !');
    }
}