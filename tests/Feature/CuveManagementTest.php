<?php

namespace Tests\Feature;

use App\Models\Cepage;
use App\Models\Cuve;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Tests\TestCase;

class CuveManagementTest extends TestCase
{
    public function test_admin_can_create_and_view_a_cuve_associated_with_a_cepage(): void
    {
        $connection = DB::connection();
        $connection->beginTransaction();

        try {
            $suffix = Str::lower(Str::random(8));
            $admin = new User([
                'Id_utilisateur' => 901,
                'Role_utilisateur' => 'admin',
            ]);
            $cepage = Cepage::create([
                'Nom_cepage' => 'Cuve' . $suffix,
                'Couleur_cepage' => 'Rouge',
                'Teneur_suc_cepage' => 18,
                'Region_cepage' => 'Test',
                'Image_cepage' => '',
                'Description_cepage' => 'Cépage temporaire pour le test des cuves',
                'Prix_kg_cepage' => 2000,
                'Qte_cepage_disponible' => 20,
            ]);

            $this->actingAs($admin)
                ->post(route('cuves.store'), [
                    'Lettre_cuve' => 'g',
                    'Capacite_cuve' => 4200,
                    'Nom_cepage' => $cepage->Nom_cepage,
                ])
                ->assertRedirect(route('cuves.index'));

            $this->assertDatabaseHas('cuves', [
                'Lettre_cuve' => 'G',
                'Capacite_cuve' => 4200,
                'Nom_cepage' => $cepage->Nom_cepage,
            ]);

            $this->get(route('cuves.index'))
                ->assertOk()
                ->assertSeeText('Cuve G')
                ->assertSeeText($cepage->Nom_cepage);

            $this->put(route('cuves.update', 'G'), [
                'Capacite_cuve' => 5000,
                'Nom_cepage' => null,
            ])->assertRedirect(route('cuves.index'));

            $this->assertDatabaseHas('cuves', [
                'Lettre_cuve' => 'G',
                'Capacite_cuve' => 5000,
                'Nom_cepage' => null,
            ]);
        } finally {
            $connection->rollBack();
        }
    }
}
