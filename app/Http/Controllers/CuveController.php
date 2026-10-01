<?php

namespace App\Http\Controllers;

use App\Models\Cuve;
use App\Models\Cepage;
use Illuminate\Http\Request;

/** Gère les cuves et leur affectation facultative à un cépage. */
class CuveController extends Controller
{
    public function index()
    {
        $cuves = Cuve::with('cepage')->get();
        return view('cuves.index', compact('cuves'));
    }

    public function create()
    {
        $cepages = Cepage::all();
        return view('cuves.create', compact('cepages'));
    }

    public function store(Request $request)
    {
        $request->merge([
            'Lettre_cuve' => strtoupper((string) $request->input('Lettre_cuve')),
        ]);

        $validated = $request->validate([
            'Lettre_cuve' => ['required', 'alpha', 'size:1', 'unique:cuves,Lettre_cuve'],
            'Capacite_cuve' => ['required', 'numeric', 'gt:0'],
            'Nom_cepage' => ['nullable', 'string', 'exists:cepages,Nom_cepage'],
        ]);

        $validated['Lettre_cuve'] = strtoupper($validated['Lettre_cuve']);
        Cuve::create($validated);

        return redirect()->route('cuves.index')->with('success', 'Cuve ajoutée avec succès !');
    }

    public function edit(string $id)
    {
        $cuve = Cuve::findOrFail($id);
        $cepages = Cepage::all();
        return view('cuves.edit', compact('cuve', 'cepages'));
    }

    public function update(Request $request, string $id)
    {
        $cuve = Cuve::findOrFail($id);

        $validated = $request->validate([
            'Capacite_cuve' => ['required', 'numeric', 'gt:0'],
            'Nom_cepage' => ['nullable', 'string', 'exists:cepages,Nom_cepage'],
        ]);

        $cuve->update($validated);

        return redirect()->route('cuves.index')->with('success', 'Cuve mise à jour !');
    }

    public function destroy(string $id)
    {
        $cuve = Cuve::findOrFail($id);
        $cuve->delete();

        return redirect()->route('cuves.index')->with('success', 'Cuve supprimée !');
    }
}