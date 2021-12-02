<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <!-- import shared style -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

{{--    import bootstap--}}
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">


    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>*|MC:SUBJECT|*</title>
    <style type="text/css">

        body{
            font-family: "Manrope";
        }
        .background{
            background-color: rgb(232 233 235);
            padding-top: 50pt;
            height: 1024pt;
        }
        .email-content{
            width: 700pt;
            height: 800pt;
            margin-left: auto;
            margin-right: auto;
            background-color: rgb(255 255 255);
            border-radius: 10pt;
        }
        .top-container{
            height: 200pt;
            background-color: rgb( 187 220 224);
            border-top-right-radius: 10pt;
            border-top-left-radius: 10pt;
        }
        .title-text{
             font-size: 36pt;
             color: rgb(69 81 93);
             line-height: 40pt;
             letter-spacing: -1pt;
            font-weight: bold;
            width: 237pt;
            margin-left: 30pt !important;
         }
        .header-title{
            font-size: 36pt;
            color: rgb(69 81 93);
            line-height: 43pt;
            letter-spacing: -1pt;
            margin-right: 30pt;
        }
        .bottom-container{

        }
        .h3{
            font-size: 16pt;
            color: rgb(162 168 174);
            letter-spacing: -0.44pt;
            margin-top: 39pt;
            font-weight: bold;
        }
        .h1{
            font-size: 36pt;
            color: rgb(69 81 93);
            line-height: 40pt;
            letter-spacing: -1pt;
            font-weight: bold;
            margin-top: 10pt;
        }
        .h2{
            font-size: 18pt;
            color: rgb(69 81 93);
            line-height: 25pt;
            letter-spacing: 0pt;
            margin-top: 5pt;
        }
        .h4{
            font-size: 14pt;
            color: rgb(69 81 93);
            line-height: 21pt;
            letter-spacing: 0pt;
            margin-top: 13pt;
        }
        i{
            color: #0a0302;
        }
        .btn{
            border-color: rgb(208 211 214);
            background-color: rgb(255 255 255);
            color: rgb(141 196 203);
            width: 200pt;
            height: 40pt;
            border-radius: 30pt;
        }
        .btn:focus{
            outline: none;
            box-shadow: unset;
        }
        table{
            width: 640pt;
            margin-left: 30pt;
            margin-right: 60pt;
        }
        p{
            color: rgb(69 81 93);
            margin-top: 65pt;
        }
        img{
            width: 36pt;
            height: 36pt;
            margin-right: 10pt;
            cursor: pointer;
        }

        </style>
    <body>
    <div class="background">
        <div class="email-content">
            <table style="margin-left: unset; width: 700pt">
            <div >
                <tr class="top-container">
                    <td style="border-top-left-radius: 10pt;"><div class="title-text">Little Miracles by Sherin</div></td>
                            <td style="text-align: right; border-top-right-radius: 10pt;" ><div class="header-title">Invoice</div></td></tr>
            </div>
            </table>
            <table>
            <div class="email-container">
            <div class="bottom-container">
                <tr>
                    <td>
               <div class="h3">Invoice Summary</div>
                    </td>
                   <td style="text-align: right">
                       <div class="h3">Total</div>
                   </td>
                </tr>
               </div>

            <div class="bottom-container">
                <tr>
                    <td>
                <div class="h1">Mini Session</div>
                    </td>
                    <td style="text-align: right">
                <div class="h1" style="font-size: 24pt; letter-spacing: -0.67pt">BD80</div>
                    </td>
                </tr>
            </div>
                <tr>
                    <td>
                <div class="h2">Monthly Promotion</div>
                    </td>
                </tr>
                <tr>
                    <td>
                <div class="h2" style="font-weight: bold">08/01/2022</div>
                    </td>
                </tr>
            <div class="bottom-container">
                <tr>
                    <td>
                <div class="h4" style="margin-top: 12pt">
                    <i style="color: rgb(141 196 203);font-size: 16pt;margin-right: 8pt;" class="far fa-calendar-day"></i>
                    8th, January 2022
                </div>
                    </td>
                    <td style="text-align: right">
                <div>
                    <button type="button" class="btn"><i style="color: rgb(141 196 203);font-size: 16pt;margin-right: 2pt;" class="far fa-calendar-day"></i>
                        Add to Calendar</button>
                </div>
                    </td>
                </tr>
            </div>
                <div class="bottom-container">
                    <tr>
                        <td>
                <div class="h4"><i style="color: rgb(141 196 203);font-size: 16pt;margin-right: 8pt;" class="far fa-clock"></i>
                    04:00 PM</div>
                        </td>
                    </tr>
                </div>
                <tr>
                    <td>
                <div class="h4"><i style="color: rgb(141 196 203);font-size: 16pt;margin-right: 8pt;" class="far fa-user"></i>
                    1 baby, 2 adult</div>
                    </td>
                </tr>
                <tr>
                    <td>
                <div class="h4"><i style="color: rgb(141 196 203);font-size: 16pt;margin-right: 8pt;" class="far fa-image-polaroid"></i>
                    Pastel Rainbow Backdrop</div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <p>
                            Invoice generated on Wednesday 24/06/2022 05:00PM
                        </p>
                        <hr>
                    </td>
                </tr>
                <tr>
                    <td>
                      <div class="h4" style="margin-top: 64pt;">Follow our Social Media</div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <img src="images/iconsSocialInstagram.svg">
                        <img src="images/iconsSocialFacebook.svg">
                        <img src="images/iconsSocialSnapchat.svg">
                        <img src="images/iconsSocialTwitter.svg">
                        <img src="images/iconsSocialYoutube.svg">
                        <img src="images/iconsSocialPinterest.svg">
                    </td>
                </tr>
                <tr>
                    <td>
                        <p style="margin-top: 20pt">Little Miracles by Sherin 2022 All Rights Reserved</p>
                    </td>
                </tr>

            </div></table>
        </div>
    </div>
    </body>
</html>
