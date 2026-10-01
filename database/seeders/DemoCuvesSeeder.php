<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DemoCuvesSeeder extends Seeder
{
    public function run(): void
    {
        $cepages = DB::table('cepages')
            ->whereIn('Nom_cepage', [
                'Demo Merlot',
                'Demo Cabernet',
                'Demo Chardonnay',
                'Demo Rosé',
                'Demo Pinot Gris',
            ])
            ->pluck('Nom_cepage')
            ->all();

        $affectations = [
            'A' => ['capacite' => 5000, 'cepage' => 'Demo Merlot'],
            'B' => ['capacite' => 7500, 'cepage' => 'Demo Cabernet'],
            'C' => ['capacite' => 4000, 'cepage' => 'Demo Chardonnay'],
            'D' => ['capacite' => 3000, 'cepage' => 'Demo Rosé'],
            'E' => ['capacite' => 6000, 'cepage' => null],
            'F' => ['capacite' => 2500, 'cepage' => 'Demo Pinot Gris'],
        ];

        foreach ($affectations as $lettre => $affectation) {
            $nomCepage = $affectation['cepage'];
            if ($nomCepage !== null && !in_array($nomCepage, $cepages, true)) {
                continue;
            }

            DB::table('cuves')->updateOrInsert(
                ['Lettre_cuve' => $lettre],
                [
                    'Capacite_cuve' => $affectation['capacite'],
                    'Nom_cepage' => $nomCepage,
                ]
            );
        }
    }
}
