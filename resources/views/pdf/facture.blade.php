<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Facture / Bon de Livraison #{{ $livraison->Num_livraison }}</title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 14px; color: #333; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #800020; padding-bottom: 10px; }
        .header h1 { color: #800020; margin: 0; }
        .details { margin-bottom: 20px; width: 100%; }
        .details td { padding: 5px; }
        .table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .table th, .table td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        .table th { background-color: #800020; color: white; }
        .total { text-align: right; margin-top: 20px; font-size: 16px; font-weight: bold; color: #800020; }
        .footer { text-align: center; margin-top: 50px; font-size: 11px; color: #777; }
    </style>
</head>
<body>
    @php
        $prixUnitaire = (float) ($livraison->contrat->cepage->Prix_kg_cepage ?? 0);
        $montantTotal = (float) $livraison->Qte_livree * $prixUnitaire;
    @endphp

    <div class="header">
        <h1>SOCIÉTÉ VITICOLE</h1>
        <p>Bon de Livraison & Facture d'Achat</p>
    </div>

    <table class="details">
        <tr>
            <td><strong>N° Livraison :</strong> {{ $livraison->Num_livraison }}</td>
            <td><strong>Date :</strong> {{ \Carbon\Carbon::parse($livraison->Date_livree)->format('d/m/Y') }}</td>
        </tr>
        <tr>
            <td><strong>N° Contrat :</strong> {{ $livraison->Num_contrat }}</td>
            <td><strong>Cépage :</strong> {{ $livraison->contrat->Nom_cepage ?? 'N/A' }}</td>
        </tr>
    </table>

    <table class="table">
        <thead>
            <tr>
                <th>Désignation</th>
                <th>Quantité Livrée</th>
                <th>Prix Unitaire (Est.)</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Cépage {{ $livraison->contrat->Nom_cepage ?? '' }}</td>
                <td>{{ number_format($livraison->Qte_livree, 2, ',', ' ') }} Kg</td>
                <td>{{ number_format($prixUnitaire, 0, ',', ' ') }} FCFA / Kg</td>
                <td>{{ number_format($montantTotal, 0, ',', ' ') }} FCFA</td>
            </tr>
        </tbody>
    </table>

    <div class="total">
        Montant Total : {{ number_format($montantTotal, 0, ',', ' ') }} FCFA
    </div>

    <div class="footer">
        Merci pour votre confiance. Société Viticole - Document généré automatiquement.
    </div>

</body>
</html>