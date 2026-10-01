<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DemoCepagesSeeder extends Seeder
{
    public function run(): void
    {
        $cepages = [
            [
                'Nom_cepage' => 'Demo Merlot',
                'Couleur_cepage' => 'Rouge',
                'Teneur_suc_cepage' => 18.50,
                'Region_cepage' => 'Bordeaux',
                'Image_cepage' => 'https://images.unsplash.com/photo-1516594915697-87eb3b1c14ea?auto=format&fit=crop&w=1000&q=80',
                'Description_cepage' => 'Un rouge souple et généreux aux notes de fruits mûrs, idéal pour découvrir les cépages du Domaine.',
                'Prix_kg_cepage' => 2500,
                'Qte_cepage_disponible' => 180,
            ],
            [
                'Nom_cepage' => 'Demo Cabernet',
                'Couleur_cepage' => 'Rouge',
                'Teneur_suc_cepage' => 17.20,
                'Region_cepage' => 'Médoc',
                'Image_cepage' => 'https://images.unsplash.com/photo-1510812431401-41d2bd2722f3?auto=format&fit=crop&w=1000&q=80',
                'Description_cepage' => 'Une variété structurée et expressive, avec une belle profondeur et une finale persistante.',
                'Prix_kg_cepage' => 3200,
                'Qte_cepage_disponible' => 125,
            ],
            [
                'Nom_cepage' => 'Demo Syrah',
                'Couleur_cepage' => 'Rouge',
                'Teneur_suc_cepage' => 19.10,
                'Region_cepage' => 'Rhône',
                'Image_cepage' => 'https://images.unsplash.com/photo-1510812431401-41d2bd2722f3?auto=format&fit=crop&w=1000&q=80',
                'Description_cepage' => 'Un profil intense et épicé, sélectionné pour sa couleur profonde et son caractère affirmé.',
                'Prix_kg_cepage' => 2800,
                'Qte_cepage_disponible' => 92,
            ],
            [
                'Nom_cepage' => 'Demo Chardonnay',
                'Couleur_cepage' => 'Blanc',
                'Teneur_suc_cepage' => 20.00,
                'Region_cepage' => 'Bourgogne',
                'Image_cepage' => 'https://images.unsplash.com/photo-1516594798947-e65505dbb29d?auto=format&fit=crop&w=1000&q=80',
                'Description_cepage' => 'Un blanc équilibré aux notes fraîches et florales, apprécié pour sa polyvalence.',
                'Prix_kg_cepage' => 3000,
                'Qte_cepage_disponible' => 145,
            ],
            [
                'Nom_cepage' => 'Demo Sauvignon',
                'Couleur_cepage' => 'Blanc',
                'Teneur_suc_cepage' => 18.80,
                'Region_cepage' => 'Loire',
                'Image_cepage' => 'https://images.unsplash.com/photo-1516594915697-87eb3b1c14ea?auto=format&fit=crop&w=1000&q=80',
                'Description_cepage' => 'Une variété vive et aromatique aux accents d’agrumes et d’herbes fraîches.',
                'Prix_kg_cepage' => 2700,
                'Qte_cepage_disponible' => 110,
            ],
            [
                'Nom_cepage' => 'Demo Rosé',
                'Couleur_cepage' => 'Rosé',
                'Teneur_suc_cepage' => 19.40,
                'Region_cepage' => 'Provence',
                'Image_cepage' => 'https://images.unsplash.com/photo-1558001373-7b93ee48ffa0?auto=format&fit=crop&w=1000&q=80',
                'Description_cepage' => 'Un rosé frais et délicat, parfait pour tester la navigation et les filtres du catalogue.',
                'Prix_kg_cepage' => 2400,
                'Qte_cepage_disponible' => 75,
            ],
            [
                'Nom_cepage' => 'Demo Grenache',
                'Couleur_cepage' => 'Rouge',
                'Teneur_suc_cepage' => 18.90,
                'Region_cepage' => 'Languedoc',
                'Image_cepage' => 'https://images.unsplash.com/photo-1516594915697-87eb3b1c14ea?auto=format&fit=crop&w=1000&q=80',
                'Description_cepage' => 'Fiche de démonstration : variété rouge aux arômes fruités, proposée pour tester le catalogue.',
                'Prix_kg_cepage' => 2600,
                'Qte_cepage_disponible' => 95,
            ],
            [
                'Nom_cepage' => 'Demo Pinot Noir',
                'Couleur_cepage' => 'Rouge',
                'Teneur_suc_cepage' => 17.80,
                'Region_cepage' => 'Bourgogne',
                'Image_cepage' => 'https://images.unsplash.com/photo-1510812431401-41d2bd2722f3?auto=format&fit=crop&w=1000&q=80',
                'Description_cepage' => 'Fiche de démonstration : cépage rouge léger aux notes de petits fruits.',
                'Prix_kg_cepage' => 3400,
                'Qte_cepage_disponible' => 68,
            ],
            [
                'Nom_cepage' => 'Demo Gamay',
                'Couleur_cepage' => 'Rouge',
                'Teneur_suc_cepage' => 18.20,
                'Region_cepage' => 'Beaujolais',
                'Image_cepage' => 'https://images.unsplash.com/photo-1516594915697-87eb3b1c14ea?auto=format&fit=crop&w=1000&q=80',
                'Description_cepage' => 'Fiche de démonstration : profil rouge souple et fruité pour les essais de commande.',
                'Prix_kg_cepage' => 2300,
                'Qte_cepage_disponible' => 120,
            ],
            [
                'Nom_cepage' => 'Demo Chenin',
                'Couleur_cepage' => 'Blanc',
                'Teneur_suc_cepage' => 19.60,
                'Region_cepage' => 'Anjou',
                'Image_cepage' => 'https://images.unsplash.com/photo-1516594798947-e65505dbb29d?auto=format&fit=crop&w=1000&q=80',
                'Description_cepage' => 'Fiche de démonstration : variété blanche polyvalente aux notes florales et fruitées.',
                'Prix_kg_cepage' => 2900,
                'Qte_cepage_disponible' => 88,
            ],
            [
                'Nom_cepage' => 'Demo Muscat',
                'Couleur_cepage' => 'Blanc',
                'Teneur_suc_cepage' => 21.10,
                'Region_cepage' => 'Alsace',
                'Image_cepage' => 'https://images.unsplash.com/photo-1516594798947-e65505dbb29d?auto=format&fit=crop&w=1000&q=80',
                'Description_cepage' => 'Fiche de démonstration : cépage blanc aromatique pour tester les fiches produit.',
                'Prix_kg_cepage' => 3100,
                'Qte_cepage_disponible' => 72,
            ],
            [
                'Nom_cepage' => 'Demo Viognier',
                'Couleur_cepage' => 'Blanc',
                'Teneur_suc_cepage' => 20.30,
                'Region_cepage' => 'Rhône',
                'Image_cepage' => 'https://images.unsplash.com/photo-1516594915697-87eb3b1c14ea?auto=format&fit=crop&w=1000&q=80',
                'Description_cepage' => 'Fiche de démonstration : variété blanche aux arômes floraux et de fruits à chair blanche.',
                'Prix_kg_cepage' => 3050,
                'Qte_cepage_disponible' => 64,
            ],
            [
                'Nom_cepage' => 'Demo Cinsault',
                'Couleur_cepage' => 'Rosé',
                'Teneur_suc_cepage' => 18.70,
                'Region_cepage' => 'Provence',
                'Image_cepage' => 'https://images.unsplash.com/photo-1558001373-7b93ee48ffa0?auto=format&fit=crop&w=1000&q=80',
                'Description_cepage' => 'Fiche de démonstration : cépage présenté en rosé, destiné aux essais de navigation.',
                'Prix_kg_cepage' => 2450,
                'Qte_cepage_disponible' => 79,
            ],
            [
                'Nom_cepage' => 'Demo Pinot Gris',
                'Couleur_cepage' => 'Gris',
                'Teneur_suc_cepage' => 19.20,
                'Region_cepage' => 'Alsace',
                'Image_cepage' => 'https://images.unsplash.com/photo-1516594798947-e65505dbb29d?auto=format&fit=crop&w=1000&q=80',
                'Description_cepage' => 'Fiche de démonstration : variété grise pour tester l’ensemble des filtres couleur.',
                'Prix_kg_cepage' => 3150,
                'Qte_cepage_disponible' => 55,
            ],
        ];

        foreach ($cepages as $cepage) {
            DB::table('cepages')->updateOrInsert(
                ['Nom_cepage' => $cepage['Nom_cepage']],
                $cepage + ['Date_ajout' => now()]
            );
        }
    }
}