<?php

namespace App\Http\Controllers;

use Adyen\AdyenException;
use Illuminate\Http\Request;
use Adyen\Client as AdyenClient;
use GuzzleHttp\Client as GuzzleClient;
use Adyen\Service\Checkout as AdyenCheckout;

class Checkout extends Controller
{
    private $adyen;
    private $checkout;
    private $returnUrl;
    private $merchantAccount;

    public function __construct()
    {
        $this->returnUrl = 'https://betalabs.com.br';
        $this->merchantAccount = 'JONASRODRIGUESANASTACIO45357247846BR819';

        try {
            $this->adyen = new AdyenClient();
        } catch (AdyenException $e) {
            abort($e->getCode(), $e->getMessage());
        }

        $this->adyen->setApplicationName('Adyen Integration');
        $this->adyen->setXApiKey(
            'AQFAhmfuXNWTK0Qc+iSavUoZlNa0bLlkKqZva0R450ufv0VisZMjQ5M2VGM2Vq'.
            'Suk9jNb1RIQoigghYNC5teNT+WvBDBXVsNvuR83LVYjEgiTGAH-tY3y2T/GYlH'.
            '9kfgdlLuR91hu1Et85MXO7BzDsrgH4yo=-dtq99QGK2898d6Nm'
        );
        $this->adyen->setEnvironment(\Adyen\Environment::TEST);

        try {
            $this->checkout = new AdyenCheckout($this->adyen);
        } catch (AdyenException $e) {
            abort($e->getCode(), $e->getMessage());
        }
    }

    public function paymentMethods(Request $request) {

        $params = [
            'merchantAccount' => $request->merchantAccount,
            'countryCode' => 'BR',
            'amount' => [ 'currency' => 'BRL', 'value' => $request->value ]
        ];

        $response = $this->checkout->paymentMethods($params);

        return $response;

    }

    public function boletoPayment(Request $data) {

        $data = [
            'amount' => [ 'value' => $data->value, 'currency' => 'BRL' ],

            'billingAddress' => [
                'city' => $data->billingAddress['city'],
                'country' => $data->billingAddress['country'],
                'houseNumberOrName' => $data->billingAddress['houseNumberOrName'],
                'postalCode' => $data->billingAddress['postalCode'],
                'stateOrProvince' => $data->billingAddress['stateOrProvince'],
                'street' => $data->billingAddress['street'],
            ],

            'deliveryDate' => $data->deliveryDate,
            'reference' => $data->reference,
            'merchantAccount' => $data->merchantAccount,
            'selectedBranch' => $data->selectedBranch,

            'shopperName' => [ 'firstName' => $data['shopperName']['first'], 'lastName' => $data['shopperName']['last'] ],

            'shopperStatement' => 'Observacao boleto',
            'socialSecurityNumber' => $data['socialSecurityNumber']
        ];

        $payment = $this->checkout->payments($data);

        return $payment;

    }

    public function creditCardPayment(Request $data) {

       $shopper = [
           'name' => 'Wade Wilson'
       ];

        $data = [
            'amount' => [ 'value' => $data->value, 'currency' => 'BRL' ],

            'paymentMethod' => [
                'type' => 'scheme',
                'encryptedCardNumber' => $data->encryptedCardNumber,
                'encryptedExpiryMonth' => $data->encryptedExpiryMonth,
                'encryptedExpiryYear' => $data->encryptedExpiryYear,
                'holderName' => $shopper['name'],
                'encryptedSecurityCode' => $data->encryptedSecurityCode,
                'storeDetails' => true
            ],

            'reference' => '#'.rand(1000, 9999).date('s'),

            'returnUrl' => $this->returnUrl,
            'merchantAccount' => $this->merchantAccount
        ];

        $payment = $this->checkout->payments($data);

        return $payment;

    }
}