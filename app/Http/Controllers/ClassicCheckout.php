<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClassicCheckout extends Controller
{
    private $ch;
    private $merchantAccount;

    public function __construct()
    {
        $this->merchantAccount = 'JONASRODRIGUESANASTACIO45357247846BR819';

        $this->ch = curl_init();

        curl_setopt($this->ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'X-API-Key: AQFAhmfuXNWTK0Qc+iSavUoZlNa0bLlkKqZva0R450ufv0VisZMjQ5M2VGM2VqSuk9jNb1RIQoigghYNC5teNT+WvBDBXVsNvuR83LVYjEgiTGAH-tY3y2T/GYlH9kfgdlLuR91hu1Et85MXO7BzDsrgH4yo=-dtq99QGK2898d6Nm'
        ));
        curl_setopt($this->ch, CURLOPT_POST, 1);

        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
    }

    public function authorizePurchase(Request $request)
    {
        if (isset($request->merchantAccount)) {
            $this->merchantAccount = $request->merchantAccount;

            curl_setopt($this->ch, CURLOPT_HTTPHEADER, array(
                'X-API-Key: '.$request->apiKey
            ));
        }

        $data = [
            'additionalData' => [ 'card.encrypted.json' => $request->{'adyen-encrypted-data'} ],
            'amount' => [ 'value' => $request->value, 'currency' => 'USD' ],
            'reference' => $request->transactionReference,
            'merchantAccount' => $this->merchantAccount,
            "shopperEmail" => $request->user['email'],
            "shopperReference" => $request->user['id'],
            "recurring"=> [
                "contract" => "RECURRING,ONECLICK"
            ]
        ];

        if (isset($request->recurringDetailRefference)) {
            $data["selectedRecurringDetailReference"] = $request->recurringDetailRefference;
        }

        curl_setopt($this->ch, CURLOPT_URL, 'https://pal-test.adyen.com/pal/servlet/Payment/v40/authorise');

        curl_setopt($this->ch, CURLOPT_POSTFIELDS, json_encode($data));

        $response = curl_exec($this->ch);
        $response = json_decode($response);
        $httpcode = curl_getinfo($this->ch, CURLINFO_HTTP_CODE);

        curl_close ($this->ch);

        $response->recurringDetailReference = $httpcode == 200
                    ? $this->getRecurringDetails($request->user['id'])
                    : false;

        return response(json_encode($response), $httpcode);
    }

    public function cancelPurchase(Request $request)
    {
        if (isset($request->merchantAccount)) {
            $this->merchantAccount = $request->merchantAccount;

            curl_setopt($this->ch, CURLOPT_HTTPHEADER, array(
                'X-API-Key: '.$request->apiKey
            ));
        }

        $data = [
            'originalReference' => $request->pspReference,
            'reference' => $request->transactionReference,
            'merchantAccount' => $this->merchantAccount,
        ];

        curl_setopt($this->ch, CURLOPT_URL, 'https://pal-test.adyen.com/pal/servlet/Payment/v40/cancel');

        curl_setopt($this->ch, CURLOPT_POSTFIELDS, json_encode($data));

        $response = curl_exec($this->ch);
        $response = json_decode($response);
        $httpcode = curl_getinfo($this->ch, CURLINFO_HTTP_CODE);

        curl_close ($this->ch);

        return response(json_encode($response), $httpcode);

    }

    public function getBoleto(Request $request)
    {
        if (isset($request->merchantAccount)) {
            $this->merchantAccount = $request->merchantAccount;

            curl_setopt($this->ch, CURLOPT_HTTPHEADER, array(
                'X-API-Key: '.$request->apiKey
            ));
        }

        $data = [
            'amount' => [ 'value' => $request->value, 'currency' => 'USD' ],

            'reference' => $request->transactionReference,
            'merchantAccount' => $this->merchantAccount,
            "shopperEmail" => $request->user['email'],
            "shopperReference" => $request->user['id'],

            "deliveryDate" => date('c', strtotime($request->deliveryDate)),
            "selectedBrand" => "boletobancario_santander",

            "billingAddress" => [
                "city" => $request->user['billingAddress']['city'],
                "country" => $request->user['billingAddress']['country'],
                "houseNumberOrName" => $request->user['billingAddress']['houseNumber'],
                "postalCode" => $request->user['billingAddress']['postalCode'],
                "stateOrProvince" => $request->user['billingAddress']['state'],
                "street" => $request->user['billingAddress']['street']
            ],

            "shopperName"=> [
                "firstName" => $request->user["firstName"],
                "lastName" => $request->user["lastName"]
            ],

            "shopperStatement" => "Aceitar o pagamento até 15 dias após o vencimento.&#xA;Não cobrar juros. Não aceitar o pagamento com cheque",
            "socialSecurityNumber" => $request->user['cpf']
        ];

        curl_setopt($this->ch, CURLOPT_URL, 'https://pal-test.adyen.com/pal/servlet/Payment/v40/authorise');

        curl_setopt($this->ch, CURLOPT_POSTFIELDS, json_encode($data));

        $response = curl_exec($this->ch);
        $response = json_decode($response);
        $httpcode = curl_getinfo($this->ch, CURLINFO_HTTP_CODE);

        curl_close ($this->ch);

        return response(json_encode($response), $httpcode);
    }

    public function getRecurringDetails($user_id) {

        $this->__construct();

        $data = [
            'recurring' => [ 'contract' => 'RECURRING' ],
            'shopperReference' => $user_id,
            'merchantAccount' => $this->merchantAccount
        ];

        curl_setopt($this->ch, CURLOPT_URL, 'https://pal-test.adyen.com/pal/servlet/Recurring/v25/listRecurringDetails');

        curl_setopt($this->ch, CURLOPT_POSTFIELDS, json_encode($data));

        $response = curl_exec($this->ch);
        $response = json_decode($response);
        $details = [];
        foreach ($response->details as $key => $detail) {
            $details[] = [
                'reference' => $detail->RecurringDetail->recurringDetailReference,
                'card' => (array) $detail->RecurringDetail->card,
                'variant' => $detail->RecurringDetail->variant
            ];
        }

        $httpcode = curl_getinfo($this->ch, CURLINFO_HTTP_CODE);

        curl_close ($this->ch);

        return $details;

    }


}
