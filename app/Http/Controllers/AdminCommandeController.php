<?php

namespace App\Http\Controllers;

use App\Models\CommandeClient;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

/** Permet à l'administration de consulter les commandes et d'en faire évoluer le statut. */
class AdminCommandeController extends Controller
{
    public function index(): View
    {
        $commandes = CommandeClient::with(['client', 'lignes'])
            ->latest('created_at')
            ->paginate(15);

        return view('admin.commandes.index', [
            'commandes' => $commandes,
            'statuts' => CommandeClient::STATUTS,
        ]);
    }

    public function modifierStatut(Request $request, CommandeClient $commande): RedirectResponse
    {
        $validated = $request->validate([
            'Statut_commande' => ['required', Rule::in(CommandeClient::STATUTS)],
        ]);

        $commande->update($validated);

        return redirect()->route('admin.commandes.index')->with(
            'success',
            'Le statut de la commande n°' . $commande->Id_commande . ' a été mis à jour.'
        );
    }
}