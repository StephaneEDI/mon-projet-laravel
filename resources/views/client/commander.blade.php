<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Passer une Commande - {{ $cepage->Nom_cepage }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5" style="max-width: 600px;">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Commande de Cépage : {{ $cepage->Nom_cepage }}</h4>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('commande.valider') }}" method="POST">
                @csrf
                <input type="hidden" name="Nom_cepage" value="{{ $cepage->Nom_cepage }}">

                <div class="mb-3">
                    <label class="form-label fw-bold">Quantité souhaitée (en Kg)</label>
                    <input type="number" id="qte" name="Qte_commande" class="form-control" value="10" min="1" required oninput="calculerTotal()">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Prix indicatif au Kg (FCFA)</label>
                    <input type="number" id="prix" name="Prix_unitaire" class="form-control" value="1500" readonly>
                </div>

                <div class="alert alert-info d-flex justify-content-between align-items-center">
                    <span>Montant Total à Payer :</span>
                    <strong id="total-affichage" class="fs-4 text-primary">15 000 FCFA</strong>
                </div>

                <button type="submit" class="btn btn-success w-100 btn-lg mt-3">
                    Procéder au Paiement (Mobile Money / Carte)
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    function calculerTotal() {
        let qte = document.getElementById('qte').value || 0;
        let prix = document.getElementById('prix').value || 0;
        let total = qte * prix;
        document.getElementById('total-affichage').innerText = total.toLocaleString() + ' FCFA';
    }
</script>

</body>
</html>
