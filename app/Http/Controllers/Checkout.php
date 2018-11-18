<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Adyen\Client as AdyenClient;
use Adyen\Service\Checkout as AdyenCheckout;

class Checkout extends Controller
{
    public function paymentMethods(Request $request) {

        $adyen = new AdyenClient();
        $adyen->setApplicationName('Adyen Integration');
        $adyen->setXApiKey(
            'AQFAhmfuXNWTK0Qc+iSavUoZlNa0bLlkKqZva0R450ufv0VisZMjQ5M2VGM2VqSuk9jNb1RIQoigghYNC5teNT+' .
            'WvBDBXVsNvuR83LVYjEgiTGAH-l+92ba2GNzQQsL9Gqw4teiLZfctGxQA/X7JF15HYonw=-bL2e8xJxMBS4HRH3'
        );
        $adyen->setEnvironment(\Adyen\Environment::TEST);

        $checkout = new AdyenCheckout($adyen);

        $params = ['merchantAccount' => $request->merchantAccount];

        $response = $checkout->paymentMethods($params);

        dd($response);

    }

    public function payment(Request $request) {

        $validade = explode('/', $request->validade);
        $validade = [
            'mes' => $validade[0],
            'ano' => $validade[1]
        ];

        $payment_data = [
            'amount' => [
               'currency' => 'USD',
               'value' => $request->preco
            ],
            'referece' => $request->id_alias,
            'paymentMethod' => [
                'type' => 'scheme',
                'number' => $request->card_number,
                'expiryMonth' => $validade['mes'],
                'expiryYear' => $validade['ano'],
                'holderName' => $request->cliente['nome1'] . ' ' . $request->cliente['nome2'],
                'cvc' => $request->cvc
            ],
            'returnUrl' => 'http://betalabs.com.br',
            'merchantAccount' => 'JONASRODRIGUESANASTACIO45357247846048'
        ];

        $guzzle = new GuzzleClient(['base_uri' => 'https://docs.adyen.com/api-explorer/api/checkout/v40/']);
        $guzzle->post('payment', '');

        echo response()->json($payment_data);
    }
}