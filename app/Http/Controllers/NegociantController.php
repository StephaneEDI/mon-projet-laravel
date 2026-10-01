<?php

namespace App\Http\Controllers;

use App\Models\Negociant;
use Illuminate\Http\Request;

/** Gère les coordonnées des négociants référencés par les contrats. */
class NegociantController extends Controller
{
    public function index()
    {
        $negociants = Negociant::all();
        return view('negociants.index', compact('negociants'));
    }

    public function create()
    {
        return view('negociants.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'Id_negociant' => 'required|integer|min:1|unique:negociants,Id_negociant',
            'Nom_negociant' => 'required|max:20',
            'Prenom_negociant' => 'required|max:30',
            'Telephone_negociant' => 'required|max:15',
        ]);

        Negociant::create($request->all());

        return redirect()->route('negociants.index')->with('success', 'Négociant ajouté avec succès !');
    }

    public function edit(string $id)
    {
        $negociant = Negociant::findOrFail($id);
        return view('negociants.edit', compact('negociant'));
    }

    public function update(Request $request, string $id)
    {
        $negociant = Negociant::findOrFail($id);

        $request->validate([
            'Nom_negociant' => 'required|max:20',
            'Prenom_negociant' => 'required|max:30',
            'Telephone_negociant' => 'required|max:15',
        ]);

        $negociant->update($request->all());

        return redirect()->route('negociants.index')->with('success', 'Négociant mis à jour !');
    }

    public function destroy(string $id)
    {
        $negociant = Negociant::findOrFail($id);
        $negociant->delete();

        return redirect()->route('negociants.index')->with('success', 'Négociant supprimé !');
    }
}