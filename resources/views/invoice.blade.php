<!DOCTYPE html>
<html>
<head>
    <link href='https://fonts.googleapis.com/css?family=Manrope' rel='stylesheet'>
    <style>
        /* Add styles for the invoice */
        .invoice {
            font-family: "Manrope";
            width: 700px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Add styles for the company logo */
        .logo {
            float: left;
            width: 134.89px;
            height: 134.89px;
            background-image: url(logo.png);
            background-size: cover;
            margin-right: 24px;
        }

        /* Add styles for the invoice header */
        .header {
            overflow: hidden;
            margin-bottom: 8px;
        }

        /* Add styles for the invoice title */
        .title {
            font-size: 24px;
            font-weight: bold;
            margin-top: 16px;
            float: left;
        }

        /* Add styles for the invoice details */
        .details {
            font-size: 16px;
        }

        .detailsFontsCompany {
            color: #45515D;
        }

        .detailsFonts {
            color: #45515D;
            font-size: 12px;
        }

        /* Add styles for the invoice table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 128px;
        }

        th, td {
            /* border: 1px solid #ddd; */
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #ddd;
        }

        .setItRight {
            text-align: right;
        }

        .setFont1 {
            font-size: 18px;
            font-weight: 700;
            color: #45515D;
        }
        .setFont2 {
            font-size: 16px;
            font-weight: 700;
            color: #737C85;
        }
        .borderBottom {
            border-bottom: 1px solid #ddd;
        }
        small {
            color: #737C85;
        }
    </style>
</head>
<body>
<div class="invoice">
    <!-- Add the company logo -->
    <div class="logo"></div>

    <!-- Add the invoice header -->
    <div class="header">
        <!-- Add the invoice details -->
        <div class="details">
            <p class="detailsFontsCompany">LITTLE MIRACLES PHOTOGRAPHY W.L.L</p>
            <p class="detailsFonts">Flat/Shop No. 0, Building 107,<br>
                Road/Street 1401, AL HAMALAH,<br>
                Block 1014, Bahrain
            </p>
            <p class="detailsFonts">VAT account number: 220018945400002</p>
        </div>
    </div>

    <div class="title" style="font-weight: 700;">Tax Invoice</div>


    <table>
        <tr>
            <td class="setFont1">{{$data['name']}}</td>
        </tr>
        <tr>
            <td>{{$data['email']}}</td>
        </tr>
        <tr style="height: 100px;">
            <td>Your appointment date</td>
            <td class="setItRight">{{$data['date']}} - {{$data['time']}}</td>x
        </tr>
        <tr>
            <td class="setFont1">{{$data['package_name']}}</td>
            <td class="setItRight setFont1" >BHD {{$data['package_price']}}</td>
        </tr>
        <tr class="borderBottom">
            <td>with {{$data['photographer_name']}}</td>
            <td class="setItRight ">BHD {{$data['additional_charge']}}</td>
        </tr>
        <tr style="height: 64px;">
            <td>Subtotal</td>
            <td class="setItRight">BHD{{$data['subtotal']}}</td>
        </tr>
        <tr style="height: 64px;">
            <td>VAT (10%)</td>
            <td class="setItRight">BHD{{$data['vat_amount']}}</td>
        </tr>
        <tr style="height: 64px;" class="setFont1">
            <td>Total</td>
            <td class="setItRight">BHD{{$data['total']}}</td>
        </tr>
    </table>
    <footer style="margin-top: 128px;">
        <p><small> BHD{{$data['total']}} - {{$data['payment_method']}} </small></p>
        <p><small>{{$data['date']}} - {{$data['time']}}</small></p>
        <p><small>Payment ID #{{$data['payment_id']}}</small></p>
    </footer>
</div>
</body>
</html>
