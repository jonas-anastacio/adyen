<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Test Adyen</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .form-control label {
            height: 100%;
        }
    </style>
</head>
<body>
{{--<script type="text/javascript" src="https://test.adyen.com/hpp/cse/js/8015418815230181.shtml"></script>--}}
<form action="{{ route('classic.credit') }}" method="post" class="d-flex align-items-center position-ref h-100" id="adyen-encrypted-form">
    @csrf()
    @method('POST')
    <div class="mx-auto col-12 row m-0" style="max-width: 700px;">
        <div class="col-6">
            <div class="form-group">
                <label for="">Email</label>
                <input type="text" size="20" name="user[email]" class="form-control" value="jonas.anastacio@hotmail.com"/>
            </div>
            <div class="form-group">
                <label for="">Valor</label>
                <input type="text" name="value" class="form-control" value="35534"/>
            </div>
            <div class="form-group">
                <label for="">ID do Usuário</label>
                <input type="text" name="user[id]" class="form-control" value="546"/>
            </div>
            <div class="form-group">
                <label for="">ID da Venda</label>
                <input type="text" name="transactionReference" class="form-control" />
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label for="">CVC</label>
                <input type="text" size="4" data-encrypted-name="cvc" class="form-control" />
            </div>
            <div class="form-group">
                <label for="">Recurring Detail Reference</label>
                <input type="text" name="recurringDetailRefference" class="form-control" />
            </div>
        </div>
        <input type="hidden" id="form-expiry-generationtime" data-encrypted-name="generationtime"/>
        <button class="btn btn-success btn-lg btn-block" type="submit">Enviar</button>
    </div>
</form>

{{--<form action="{{ route('classic.credit') }}" method="post" class="d-flex align-items-center position-ref h-100" id="adyen-encrypted-form">--}}
{{--@csrf()--}}
{{--@method('POST')--}}
{{--<div class="mx-auto">--}}
{{--<div class="form-group">--}}
{{--<label for="">CVC</label>--}}
{{--<input type="text" size="4" data-encrypted-name="cvc" class="form-control" />--}}
{{--</div>--}}
{{--<div class="form-group">--}}
{{--<label for="">Nome do cliente</label>--}}
{{--<input type="text" size="20" data-encrypted-name="holderName" class="form-control" />--}}
{{--</div>--}}
{{--<div class="form-group">--}}
{{--<label for="">Valor</label>--}}
{{--<input type="text" name="value" class="form-control" />--}}
{{--</div>--}}
{{--<div class="form-group">--}}
{{--<label for="">User ID</label>--}}
{{--<input type="text" name="user_id" class="form-control" />--}}
{{--</div>--}}
{{--<div class="form-group">--}}
{{--<label for="">Recurring Detail Reference</label>--}}
{{--<input type="text" name="recurringDetailRefference" class="form-control" />--}}
{{--</div>--}}

{{--<input type="hidden" id="form-expiry-generationtime" data-encrypted-name="generationtime"/>--}}
{{--<button class="btn btn-success btn-lg btn-block" type="submit">Enviar</button>--}}
{{--</div>--}}
{{--</form>--}}
<script src="{{asset('js/adyen.encrypt.min.js')}}"></script>
<script>

    // generate time client side for testing only... Don't deploy on a
    // real integration!!!
    document.getElementById('form-expiry-generationtime').value = new Date().toISOString();

    // The form element to encrypt.
    var form = document.getElementById('adyen-encrypted-form');

    var key = '10001|9EB2555269B8D9AE889E2DEC4FF44E38B1B16C28C814CFCF99CC38522BABE01A27C99271C24DDF006F77618B'
        + 'FDE9E3852E410A68C3F2A330E9C6B7A2533E5B1E80A5323FD1119ED6053EAF5E6586EE0BF7FDF59CBE7776A0439256'
        + 'C90CC1A88C28C096EFC647BC78C82B62FA81EC1B7268BDBF33B59CCA0C43B7FE500BB105B60B5BB3AF242C44A1C255'
        + '73F50CFD6D37F2740349E2D02676A0F711CCFD19338F747E0B92FCFF7F90D1C06274A992FB3AB34BDD55E8EC76750E'
        + '2203F8AD250DB62BB50EEEC8A449802F13DAA2A33B166FA16BC22DC646A35E48447DF47EBB76066FABFC381A03CFC5'
        + '413E72039F7BF065255F48C1278565CC79214EFAFDD2A0CB';

    // See https://github.com/Adyen/CSE-JS/blob/master/Options.md for details on the options to use.
    var options = {};

    // Bind encryption options to the form.
    adyen.encrypt.createEncryptedForm(form, key, options);

</script>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
</body>
</html>
