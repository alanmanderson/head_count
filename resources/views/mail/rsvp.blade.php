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

            table {
                width: 100%;
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
        <div class="content">
            <div>
               Are you playing basketball this {{ $dayOfWeek }} ({{ $date }}) at {{ $time }} at {{ $location }}?  Please respond:
            </div>
            <a class="center" href="{{ $appUrl }}/confirm.php?user={{ $userId }}&occurance={{ $occuranceId }}&likelihood=1">
                <div class="button yes">Yes</div>
            </a>
            <a class="center" href="{{ $appUrl }}/confirm.php?user={{ $userId }}&occurance={{ $occuranceId }}&likelihood=.5"><div class="button maybe">Maybe</div></a>
            <a class="center" href="{{ $appUrl }}/confirm.php?user={{ $userId }}&occurance={{ $occuranceId }}&likelihood=0"><div class="button no">No</div></a>
            <p><a href="{{ $appUrl }}/unsubscribe.php?id={{ $userId }}&occurance={{ $occuranceId }}">Unsubscribe</a>
        </div>
    </body>
</html>