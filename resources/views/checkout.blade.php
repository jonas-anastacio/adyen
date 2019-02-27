<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">

        <!-- Bootstrap -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

        <!-- Adyen -->
        <script type="text/javascript" src="https://checkoutshopper-test.adyen.com/checkoutshopper/assets/js/sdk/checkoutSecuredFields.1.3.3.min.js"></script>

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
        <form class="flex-center position-ref h-100" action="{{ route('pay.credit') }}" method="post" id="adyen-encrypted-form">
            @csrf()
            @method('POST')
            <div class="cards-div">
                <div class="js-chckt-pm__pm-holder">
                    <input type="hidden" name="txvariant" value="card" />
                    <div class="form-group">
                        <div class="form-control">
                            <label>
                                <span class="input-field" data-cse="encryptedCardNumber"></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-control">
                            <label>
                                <span class="input-field" data-cse="encryptedExpiryMonth"></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-control">
                            <label>
                                <span class="input-field" data-cse="encryptedExpiryYear"></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-control">
                            <label>
                                <span class="input-field" data-cse="encryptedSecurityCode"></span>
                            </label>
                        </div>
                    </div>
                    <div id="pmHolder" class="js-chckt-pm__pm-holder">
                        <input type="hidden" name="txvariant" value="card">
                        <input type="hidden" name="encryptedCardNumber" id="card-encrypted-card" value="">
                        <input type="hidden" name="encryptedExpiryMonth" id="card-encrypted-month" value="">
                        <input type="hidden" name="encryptedExpiryYear" id="card-encrypted-year" value="">
                        <input type="hidden" name="encryptedSecurityCode" id="card-encrypted-code" value="">
                    </div>

                    <button type="submit" class="btn btn-success btn-lg btn-block">Pagar</button>
                </div>
            </div>

        </form>

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

        <script type="text/javascript">
            var csfSetupObj = {
                rootNode: '.cards-div',
                configObject : {
                    originKey : "pub.v2.8015418815230181.aHR0cDovL2FkeWVuLmJldGE.KfETYJbalDv9FEZ04R8azVjBqUreC611yhD-ZFMwZKI"
                }
            };
            var securedFields = csf(csfSetupObj);
        </script>
    </body>
</html>
