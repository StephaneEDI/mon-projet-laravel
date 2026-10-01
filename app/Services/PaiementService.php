<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PaiementService
{
    protected string $apiKey;
    protected string $siteId;

    public function __construct()
    {
        $this->apiKey = config('services.cinetpay.api_key', 'CLÉ_API_DEFAUT');
        $this->siteId = config('services.cinetpay.site_id', 'SITE_ID_DEFAUT');
    }

    public function initialiserPaiement(array $data)
    {
        $response = Http::post('https://api-checkout.cinetpay.com/v2/payment', [
            'apikey' => $this->apiKey,
            'site_id' => $this->siteId,
            'transaction_id' => $data['transaction_id'],
            'amount' => $data['montant'],
            'currency' => 'XOF',
            'description' => 'Achat Cépages - ' . $data['cepage'],
            'return_url' => route('contrats.index'),
            'notify_url' => url('/api/paiement/notification'),
            'customer_name' => $data['client_nom'],
            'customer_surname' => $data['client_prenom'],
            'customer_email' => $data['client_email'],
        ]);

        return $response->json();
    }
}