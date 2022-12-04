<!DOCTYPE html>
<html>
<head>
    <title>Payment Middleware</title>

    <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

    <style>
        html, body {
            height: 100%;
        }

        body {
            margin: 0;
            padding: 0;
            width: 100%;
            display: table;
            font-weight: 100;
            font-family: 'Lato';
        }

        .container {
            text-align: center;
            display: table-cell;
            vertical-align: middle;
        }

        .content {
            text-align: center;
            display: inline-block;
        }

        .title {
            font-size: 96px;
        }
    </style>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    {{--    <script src="https://{{$gateway_name}}.gateway.mastercard.com/static/checkout/checkout.min.js" data-error="errorCallback" data-cancel="cancelCallback"></script>--}}
    <script src="https://afs.gateway.mastercard.com/checkout/version/60/checkout.js" data-error="errorCallback"
            data-cancel="cancelCallback"></script>
    <script type="text/javascript">
        function errorCallback(error) {
            console.log(JSON.stringify(error));
        }

        function cancelCallback() {
            window.location.href = "{{ env("WEBSITE_URL") }}/activities";
            console.log('Payment cancelled');
        }

        Checkout.configure({
            merchant: '{{ $merchant_id }}',
            order: {
                amount: '{{ $amount }}',
                currency: '{{ $currency }}',
                description: '{{ $description }}',
            },
            session: {
                id: '{{ $session_id }}'
            },
            interaction: {
                merchant: {
                    name: '{{ $merchant_name }}',
                },
                displayControl: {
                    billingAddress: 'HIDE'
                },
                operation: "PURCHASE"
            }
        });
    </script>
</head>
<body>
<div class="container">
    <div class="content">
        <div class="title">Please wait..</div>
    </div>
</div>


<script>
    $(document).ready(function () {
        Checkout.showPaymentPage();
    });
</script>
</body>
</html>

