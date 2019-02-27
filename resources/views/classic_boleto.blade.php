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
    <form action="{{ route('classic.boleto') }}" method="post" class="d-flex align-items-center position-ref h-100" id="adyen-encrypted-form">
        @csrf()
        @method('POST')
        <div class="mx-auto col-12 row m-0" style="max-width: 700px;">
            <div class="col-6">
                <div class="form-group">
                    <label for="">Nome</label>
                    <input type="text" name="user[firstName]" class="form-control" value="Jonas"/>
                </div>
                <div class="form-group">
                    <label for="">Sobrenome</label>
                    <input type="text" name="user[lastName]" class="form-control" value="Anastacio"/>
                </div>
                <div class="form-group">
                    <label for="">Email</label>
                    <input type="text" size="20" name="user[email]" class="form-control" value="jonas.anastacio@hotmail.com"/>
                </div>
                <div class="form-group">
                    <label for="">ID do usuário</label>
                    <input type="text" name="user[id]" class="form-control" value="546"/>
                </div>
                <div class="form-group">
                    <label for="">CPF</label>
                    <input type="text" name="user[cpf]" class="form-control" value="45357247846"/>
                </div>
                <div class="form-group">
                    <label for="">Valor</label>
                    <input type="text" name="value" class="form-control" />
                </div>
                <div class="form-group">
                    <label for="">Vencimento</label>
                    <input type="text" name="deliveryDate" class="form-control" value="2019-05-20"/>
                </div>
                <div class="form-group">
                    <label for="">Observacao</label>
                    <textarea type="text" name="shopperStatement" class="form-control">Aceitar o pagamento até 15 dias após o vencimento.&#xA;Não cobrar juros. Não aceitar o pagamento com cheque</textarea>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="">Cidade</label>
                    <input type="text" size="20" name="user[billingAddress][city]" class="form-control" value="São Paulo"/>
                </div>
                <div class="form-group">
                    <label for="">Estado</label>
                    <input type="text" size="20" name="user[billingAddress][state]" class="form-control" value="SP"/>
                </div>
                <div class="form-group">
                    <label for="">Pais</label>
                    <input type="text" size="20" name="user[billingAddress][country]" class="form-control" value="BR"/>
                </div>
                <div class="form-group">
                    <label for="">Rua</label>
                    <input type="text" size="20" name="user[billingAddress][street]" class="form-control" value="Rua Graciosa Polesi Peixoto"/>
                </div>
                <div class="form-group">
                    <label for="">Numero</label>
                    <input type="text" size="20" name="user[billingAddress][houseNumber]" class="form-control" value="6 B"/>
                </div>
                <div class="form-group">
                    <label for="">CEP</label>
                    <input type="text" size="20" name="user[billingAddress][postalCode]" class="form-control" value="08051620"/>
                </div>
                <div class="form-group">
                    <label for="">ID da venda</label>
                    <input type="text" name="transactionReference" class="form-control" value=""/>
                </div>
            </div>
            <input type="hidden" id="form-expiry-generationtime" data-encrypted-name="generationtime"/>
            <button class="btn btn-success btn-lg btn-block" type="submit">Enviar</button>
        </div>
    </form>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
</body>
</html>
