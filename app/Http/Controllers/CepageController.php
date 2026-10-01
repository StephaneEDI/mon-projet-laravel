<?php

namespace App\Http\Controllers;

use App\Models\Cepage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

/** Gère les fiches cépages affichées dans le catalogue public. */
class CepageController extends Controller
{
    private const COULEURS_CEPAGE = ['Rouge', 'Blanc', 'Rosé', 'Gris'];

    // Afficher la liste des cépages
    public function index()
    {
        $cepages = Cepage::all();
        return view('cepages.index', compact('cepages'));
    }

    // Formulaire de création d'un cépage
    public function create()
    {
        return view('cepages.create', ['couleurs' => self::COULEURS_CEPAGE]);
    }

    // Enregistrer un nouveau cépage
    public function store(Request $request)
    {
        $request->validate([
            'Nom_cepage' => 'required|max:15|unique:cepages,Nom_cepage',
            'Couleur_cepage' => ['required', Rule::in(self::COULEURS_CEPAGE)],
            'Teneur_suc_cepage' => 'required|numeric',
            'Region_cepage' => 'required|max:30',
            'Image_cepage' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
            'Description_cepage' => 'required',
            'Prix_kg_cepage' => 'required|numeric',
            'Qte_cepage_disponible' => 'required|numeric',
        ]);

        $data = $request->except('Image_cepage');
        $data['Image_cepage'] = $request->file('Image_cepage')->store('cepages', 'public');

        Cepage::create($data);

        return redirect()->route('cepages.index')->with('success', 'Cépage ajouté avec succès !');
    }

    // Afficher les détails d'un cépage
    public function show(string $id)
    {
        $cepage = Cepage::findOrFail($id);
        return view('cepages.show', compact('cepage'));
    }

    // Formulaire d'édition d'un cépage
    public function edit(string $id)
    {
        $cepage = Cepage::findOrFail($id);
        return view('cepages.edit', [
            'cepage' => $cepage,
            'couleurs' => self::COULEURS_CEPAGE,
        ]);
    }

    // Mettre à jour un cépage
    public function update(Request $request,string $id)
    {
        $cepage = Cepage::findOrFail($id);

        $request->validate([
            'Couleur_cepage' => ['required', Rule::in(self::COULEURS_CEPAGE)],
            'Teneur_suc_cepage' => 'required|numeric',
            'Region_cepage' => 'required|max:30',
            'Image_cepage' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'Description_cepage' => 'required',
            'Prix_kg_cepage' => 'required|numeric',
            'Qte_cepage_disponible' => 'required|numeric',
        ]);

        $data = $request->except('Image_cepage');
        if ($request->hasFile('Image_cepage')) {
            if ($cepage->Image_cepage && !Str::startsWith($cepage->Image_cepage, ['http://', 'https://'])) {
                Storage::disk('public')->delete($cepage->Image_cepage);
            }

            $data['Image_cepage'] = $request->file('Image_cepage')->store('cepages', 'public');
        }

        $cepage->update($data);

        return redirect()->route('cepages.index')->with('success', 'Cépage mis à jour avec succès !');
    }

    // Supprimer un cépage
    public function destroy(string $id)
    {
        $cepage = Cepage::findOrFail($id);
        $cepage->delete();

        return redirect()->route('cepages.index')->with('success', 'Cépage supprimé avec succès !');
    }
}