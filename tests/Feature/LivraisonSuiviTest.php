<?php

namespace Tests\Feature;

use App\Models\Cepage;
use App\Models\CommandeClient;
use App\Models\CommandeLigne;
use App\Models\LivraisonSuivie;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Tests\TestCase;

class LivraisonSuiviTest extends TestCase
{
    public function test_admin_can_schedule_and_complete_a_partial_delivery(): void
    {
        $connection = DB::connection();
        $connection->beginTransaction();

        try {
            $suffix = Str::lower(Str::random(8));
            $admin = User::create([
                'Nom_utilisateur' => 'Admin',
                'Prenom_utilisateur' => 'Test',
                'Email_utilisateur' => $suffix . '@admin-test.example',
                'Password_utilisateur' => bcrypt('password'),
                'Role_utilisateur' => 'admin',
            ]);
            $client = User::create([
                'Nom_utilisateur' => 'Client',
                'Prenom_utilisateur' => 'Test',
                'Email_utilisateur' => $suffix . '@client-test.example',
                'Password_utilisateur' => bcrypt('password'),
                'Role_utilisateur' => 'negociant',
            ]);
            $cepage = Cepage::create([
                'Nom_cepage' => 'Liv' . $suffix,
                'Couleur_cepage' => 'Rouge',
                'Teneur_suc_cepage' => 18,
                'Region_cepage' => 'Test',
                'Image_cepage' => '',
                'Description_cepage' => 'Cépage temporaire de test',
                'Prix_kg_cepage' => 1500,
                'Qte_cepage_disponible' => 20,
            ]);
            $commande = CommandeClient::create([
                'Id_utilisateur' => $client->Id_utilisateur,
                'Montant_total' => 7500,
                'Statut_commande' => 'En attente',
            ]);
            $ligne = CommandeLigne::create([
                'Id_commande' => $commande->Id_commande,
                'Nom_cepage' => $cepage->Nom_cepage,
                'Quantite' => 5,
                'Prix_unitaire' => 1500,
                'Sous_total' => 7500,
            ]);

            $this->actingAs($admin)
                ->post(route('livraisons.suivi.store'), [
                    'Id_ligne' => $ligne->Id_ligne,
                    'Qte_prevue' => 1,
                    'Date_prevue' => now()->addDay()->toDateString(),
                ])
                ->assertSessionHasErrors('Id_ligne');

            $this->get(route('livraisons.index'))
                ->assertOk()
                ->assertSeeText('commande(s) client attend(ent) une confirmation')
                ->assertSee(route('admin.commandes.index'));

            $commande->update(['Statut_commande' => 'Confirmée']);

            $this->actingAs($admin)
                ->get(route('livraisons.index'))
                ->assertOk()
                ->assertSeeText('Commandes à planifier')
                ->assertSeeText($cepage->Nom_cepage);

            $datePrevue = now()->addDays(5)->toDateString();

            $this->post(route('livraisons.suivi.store'), [
                'Id_ligne' => $ligne->Id_ligne,
                'Qte_prevue' => 3,
            ])->assertSessionHasErrors('Date_prevue');

            $this->post(route('livraisons.suivi.store'), [
                'Id_ligne' => $ligne->Id_ligne,
                'Qte_prevue' => 3,
                'Date_prevue' => $datePrevue,
            ])->assertRedirect(route('livraisons.index'));

            $suivi = LivraisonSuivie::where('Id_ligne', $ligne->Id_ligne)->firstOrFail();
            $this->assertSame('a_effectuer', $suivi->Statut);
            $this->assertSame($datePrevue, $suivi->Date_prevue->toDateString());

            $this->actingAs($client)
                ->get(route('client.profil'))
                ->assertOk()
                ->assertSeeText($suivi->Date_prevue->format('d/m/Y'))
                ->assertSeeText('À effectuer');

            $this->actingAs($admin);
            $this->post(route('livraisons.suivi.store'), [
                'Id_ligne' => $ligne->Id_ligne,
                'Qte_prevue' => 3,
                'Date_prevue' => now()->addDay()->toDateString(),
            ])->assertSessionHasErrors('Qte_prevue');

            $this->patch(route('livraisons.suivi.statut', $suivi->Id_suivi), [
                'Statut' => 'en_cours',
            ])->assertRedirect(route('livraisons.index'));
            $this->assertDatabaseHas('livraison_suivis', [
                'Id_suivi' => $suivi->Id_suivi,
                'Statut' => 'en_cours',
            ]);

            $this->patch(route('livraisons.suivi.statut', $suivi->Id_suivi), [
                'Statut' => 'effectuee',
            ])->assertRedirect(route('livraisons.index'));

            $this->assertDatabaseHas('livraison_suivis', [
                'Id_suivi' => $suivi->Id_suivi,
                'Statut' => 'effectuee',
                'Date_reelle' => now()->toDateString(),
            ]);

            $this->patch(route('livraisons.suivi.statut', $suivi->Id_suivi), [
                'Statut' => 'en_cours',
            ])->assertSessionHasErrors('Statut');
        } finally {
            $connection->rollBack();
        }
    }
}
