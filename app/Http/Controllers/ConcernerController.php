<?php

namespace App\Http\Controllers;

use App\Models\Concerner;
use App\Models\Contrat;
use App\Models\Livraison;
use Illuminate\Http\Request;

/** Gère les associations historiques entre livraisons et contrats. */
class ConcernerController extends Controller
{
    public function index()
    {
        $concerners = Concerner::with(['contrat', 'livraison'])->get();
        return view('concerners.index', compact('concerners'));
    }

    public function create()
    {
        $contrats = Contrat::all();
        $livraisons = Livraison::all();
        return view('concerners.create', compact('contrats', 'livraisons'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'Num_contrat' => 'required|exists:contrats,Num_contrat',
            'Num_livraison' => 'required|exists:livraisons,Num_livraison',
            'Qte_livree' => 'required|numeric|min:0',
            'Date_livree' => 'required|date',
        ]);

        Concerner::create($request->all());

        return redirect()->route('concerners.index')->with('success', 'Association contrat-livraison ajoutée avec succès !');
    }

    public function edit(string $id)
    {
        $concerner = Concerner::findOrFail($id);
        $contrats = Contrat::all();
        $livraisons = Livraison::all();
        return view('concerners.edit', compact('concerner', 'contrats', 'livraisons'));
    }

    public function update(Request $request, string $id)
    {
        $concerner = Concerner::findOrFail($id);

        $request->validate([
            'Num_contrat' => 'required|exists:contrats,Num_contrat',
            'Num_livraison' => 'required|exists:livraisons,Num_livraison',
            'Qte_livree' => 'required|numeric|min:0',
            'Date_livree' => 'required|date',
        ]);

        $concerner->update($request->all());

        return redirect()->route('concerners.index')->with('success', 'Association mise à jour !');
    }

    public function destroy(string $id)
    {
        $concerner = Concerner::findOrFail($id);
        $concerner->delete();

        return redirect()->route('concerners.index')->with('success', 'Association supprimée !');
    }
}