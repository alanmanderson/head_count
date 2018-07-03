<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>RSVP</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            body {
                color: #636b6f;
                font-family: Verdana, Geneva, sans-serif;
                font-weight: 100;
            }

            .content {
                text-align: center;
            }

            .button {
                width: 130px;
                text-align: center;
                vertical-align: center;
                font-weight: bold;
                padding: 10px;
                margin: 10px;
                float: left;
                font-weight:800;
                font-size: 200%;
                clear: both;
            }

            .center {
                display: table;
                margin: auto;
            }

            .yes {
                background-color: #094400;
                color: #CCFFCC;
            }

            .no {
                background-color: #770000;
                color: #FCC;
            }

            .maybe {
                background-color: #000266;
                color: #ACF;
            }

        </style>
    </head>
    <body>
        <div class="content center">
            Tonight we are expecting the following people:<br>
            <table style="border:2px solid black; table-layout: fixed; border-collapse: collapse;">
              <tr style="border:1px solid black">
                 <td class="yes">Yes: </td>
                 <td style="word-wrap:break-word">
                     @forelse ($yeses as $reply)
                         {{ $reply->user->first_name }} {{ $reply->user->last_name }}<br>
                     @endforeach
                 </td>
              </tr>
              <tr style="border:1px solid black">
                 <td class="maybe">Maybe: </td>
                 <td style="word-wrap:break-word">
                     @forelse ($maybes as $reply)
                         {{ $reply->user->first_name }} {{ $reply->user->last_name }}
                     @endforeach
                 </td>
              </tr>
              <tr style="border:1px solid black">
                 <td class="no">No: </td>
                 <td style="word-wrap:break-word">
                     @forelse ($nos as $reply)
                         {{ $reply->user->first_name }} {{ $reply->user->last_name }}
                     @endforeach
                 </td>
              </tr>
            </table>
        </div>
    </body>
</html>