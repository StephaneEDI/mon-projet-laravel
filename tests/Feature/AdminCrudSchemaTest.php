<?php

namespace Tests\Feature;

use App\Models\Cepage;
use App\Models\Negociant;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Tests\TestCase;

class AdminCrudSchemaTest extends TestCase
{
    public function test_contract_form_lists_negociants_saved_in_the_database(): void
    {
        $connection = DB::connection();
        $connection->beginTransaction();

        try {
            $admin = new User(['Id_utilisateur' => 993, 'Role_utilisateur' => 'admin']);
            User::create([
                'Nom_utilisateur' => 'Ndiaye',
                'Prenom_utilisateur' => 'Awa',
                'Email_utilisateur' => 'awa.' . Str::lower(Str::random(6)) . '@test.example',
                'Password_utilisateur' => bcrypt('password'),
                'Role_utilisateur' => 'negociant',
            ]);
            $negociant = User::where('Nom_utilisateur', 'Ndiaye')->firstOrFail();

            $this->actingAs($admin)
                ->get(route('contrats.create'))
                ->assertOk()
                ->assertSee('name="Id_utilisateur"', false)
                ->assertSee('value="' . $negociant->Id_utilisateur . '"', false)
                ->assertSeeText('Ndiaye Awa');
        } finally {
            $connection->rollBack();
        }
    }

    public function test_admin_can_create_a_contract_using_the_real_contract_columns(): void
    {
        $connection = DB::connection();
        $connection->beginTransaction();

        try {
            $suffix = Str::lower(Str::random(7));
            $admin = new User(['Id_utilisateur' => 991, 'Role_utilisateur' => 'admin']);
            $negociant = User::create([
                'Nom_utilisateur' => 'Test',
                'Prenom_utilisateur' => 'Contrat',
                'Email_utilisateur' => $suffix . '@contrat-test.example',
                'Password_utilisateur' => bcrypt('password'),
                'Role_utilisateur' => 'negociant',
            ]);
            $cepage = Cepage::create([
                'Nom_cepage' => 'Ctr' . $suffix,
                'Couleur_cepage' => 'Rouge',
                'Teneur_suc_cepage' => 18,
                'Region_cepage' => 'Test',
                'Image_cepage' => '',
                'Description_cepage' => 'Cépage temporaire de test contrat',
                'Prix_kg_cepage' => 2000,
                'Qte_cepage_disponible' => 10,
            ]);

            $this->actingAs($admin)
                ->post(route('contrats.store'), [
                    'Num_contrat' => 910001,
                    'Date_contrat' => now()->toDateString(),
                    'Date_echeance_contrat' => now()->addMonth()->toDateString(),
                    'Qte_commande' => 5,
                    'Id_utilisateur' => $negociant->Id_utilisateur,
                    'Nom_cepage' => $cepage->Nom_cepage,
                ])
                ->assertRedirect(route('contrats.index'));

            $this->assertDatabaseHas('contrats', [
                'Num_contrat' => 910001,
                'Qte_commande' => 5,
                'Id_utilisateur' => $negociant->Id_utilisateur,
                'Nom_cepage' => $cepage->Nom_cepage,
            ]);

            $this->get(route('contrats.index'))
                ->assertOk()
                ->assertSeeText($negociant->Nom_utilisateur)
                ->assertSeeText($cepage->Nom_cepage);
        } finally {
            $connection->rollBack();
        }
    }

    public function test_admin_can_update_a_negociant_with_schema_length_limits(): void
    {
        $connection = DB::connection();
        $connection->beginTransaction();

        try {
            $admin = new User(['Id_utilisateur' => 992, 'Role_utilisateur' => 'admin']);
            $negociant = Negociant::create([
                'Id_negociant' => 910002,
                'Nom_negociant' => 'Ancien',
                'Prenom_negociant' => 'Nom',
                'Telephone_negociant' => '770000002',
            ]);

            $this->actingAs($admin)
                ->get(route('negociants.edit', $negociant->Id_negociant))
                ->assertOk()
                ->assertSeeText('Modifier le négociant');

            $this->put(route('negociants.update', $negociant->Id_negociant), [
                'Nom_negociant' => 'Nouveau',
                'Prenom_negociant' => 'Contact',
                'Telephone_negociant' => '770000003',
            ])->assertRedirect(route('negociants.index'));

            $this->assertDatabaseHas('negociants', [
                'Id_negociant' => $negociant->Id_negociant,
                'Nom_negociant' => 'Nouveau',
                'Prenom_negociant' => 'Contact',
                'Telephone_negociant' => '770000003',
            ]);
        } finally {
            $connection->rollBack();
        }
    }
}
