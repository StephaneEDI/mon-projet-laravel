<?php

namespace Tests\Feature;

use App\Models\Cepage;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    public function test_client_cannot_open_the_admin_dashboard(): void
    {
        $client = new User([
            'Id_utilisateur' => 10,
            'Role_utilisateur' => 'negociant',
        ]);

        $this->actingAs($client)
            ->get(route('admin.dashboard'))
            ->assertRedirect(route('home'));
    }

    public function test_admin_can_pass_the_admin_middleware(): void
    {
        Route::get('/_test/admin-access', fn () => response('ok'))
            ->middleware(['auth', 'admin']);

        $admin = new User([
            'Id_utilisateur' => 11,
            'Role_utilisateur' => 'admin',
        ]);

        $this->actingAs($admin)
            ->get('/_test/admin-access')
            ->assertOk()
            ->assertSeeText('ok');
    }

    public function test_admin_dashboard_shows_the_shared_module_navigation(): void
    {
        $admin = new User([
            'Id_utilisateur' => 18,
            'Role_utilisateur' => 'admin',
        ]);

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('aria-label="Navigation administration"', false)
            ->assertSeeText('Cépages')
            ->assertSeeText('Commandes')
            ->assertSeeText('Livraisons');
    }

    public function test_admin_cannot_open_the_client_cart(): void
    {
        $admin = new User([
            'Id_utilisateur' => 12,
            'Role_utilisateur' => 'admin',
        ]);

        $this->actingAs($admin)
            ->get(route('panier.index'))
            ->assertRedirect(route('admin.dashboard'));
    }

    public function test_admin_cannot_add_products_to_a_client_cart(): void
    {
        $admin = new User([
            'Id_utilisateur' => 16,
            'Role_utilisateur' => 'admin',
        ]);

        $this->actingAs($admin)
            ->post(route('panier.ajouter'))
            ->assertRedirect(route('admin.dashboard'));
    }

    public function test_admin_cannot_submit_a_cart_order_directly(): void
    {
        $admin = new User([
            'Id_utilisateur' => 20,
            'Role_utilisateur' => 'admin',
        ]);

        $this->actingAs($admin)
            ->post(route('panier.confirmer'))
            ->assertRedirect(route('admin.dashboard'));
    }

    public function test_guest_must_sign_in_before_opening_the_cart(): void
    {
        $this->get(route('panier.index'))
            ->assertRedirect(route('login'));
    }

    public function test_admin_does_not_see_the_cart_link_on_the_vitrine(): void
    {
        $admin = new User([
            'Id_utilisateur' => 13,
            'Role_utilisateur' => 'admin',
        ]);

        $this->actingAs($admin)
            ->get(route('home'))
            ->assertOk()
            ->assertDontSee('Panier ·');
    }

    public function test_admin_can_only_consult_the_vitrine_without_catalog_actions(): void
    {
        $connection = DB::connection();
        $connection->beginTransaction();

        try {
            $cepageName = 'VueAdmin' . substr(uniqid(), -6);
            Cepage::create([
                'Nom_cepage' => $cepageName,
                'Couleur_cepage' => 'Rouge',
                'Teneur_suc_cepage' => 18,
                'Region_cepage' => 'Test',
                'Image_cepage' => '',
                'Description_cepage' => 'Fiche temporaire de test',
                'Prix_kg_cepage' => 1500,
                'Qte_cepage_disponible' => 10,
            ]);

            $admin = new User([
                'Id_utilisateur' => 19,
                'Role_utilisateur' => 'admin',
            ]);

            $this->actingAs($admin)
                ->get(route('home'))
                ->assertOk()
                ->assertSeeText($cepageName)
                ->assertDontSee('Tous les cépages')
                ->assertDontSee('placeholder="Rechercher un cépage ou une région"', false)
                ->assertDontSee(route('panier.ajouter'), false)
                ->assertDontSee('Ajouter au panier');
        } finally {
            $connection->rollBack();
        }
    }

    public function test_admin_cannot_delete_a_cepage_from_the_admin_routes(): void
    {
        $this->assertFalse(Route::has('cepages.destroy'));
    }

    public function test_admin_can_open_the_order_tracking_page(): void
    {
        $admin = new User([
            'Id_utilisateur' => 14,
            'Role_utilisateur' => 'admin',
        ]);

        $this->actingAs($admin)
            ->get(route('admin.commandes.index'))
            ->assertOk()
            ->assertSeeText('Demandes de commande');
    }

    public function test_client_cannot_open_the_admin_order_tracking_page(): void
    {
        $client = new User([
            'Id_utilisateur' => 15,
            'Role_utilisateur' => 'negociant',
        ]);

        $this->actingAs($client)
            ->get(route('admin.commandes.index'))
            ->assertRedirect(route('home'));
    }

    public function test_client_cannot_open_the_delivery_tracking_page(): void
    {
        $client = new User([
            'Id_utilisateur' => 17,
            'Role_utilisateur' => 'negociant',
        ]);

        $this->actingAs($client)
            ->get(route('livraisons.index'))
            ->assertRedirect(route('home'));
    }
}