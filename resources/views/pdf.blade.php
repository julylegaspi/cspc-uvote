<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Results - {{ $organization_code }} ({{ $organization_name }}) {{ $year }}</title>


    <style>
        * {
            box-sizing: border-box;
        }

        /* Create three equal columns that floats next to each other */
        .column {
            float: left;
            text-align: center;
        }

        /* Clear floats after the columns */
        .row:after {
            content: "";
            display: table;
            clear: both;
        }

        @font-face {
            font-family: 'Inter';
            font-weight: normal;
            font-style: normal;
            font-variant: normal;
            src: url("fonts/Inter-Regular.ttf") format('truetype');
        }

        body {
            font-family: 'Inter', sans-serif;
            ;
        }
    </style>
</head>

<body>
    <div class="row">
        <div class="column" style="width: 20%; text-align:center; padding-top: 0px;">
            <img src="{{ public_path('logo/logo.png') }}" alt="CSPC logo" width="100" height="100">
        </div>
        <div class="column" style="width: 60%; text-align:center;">
            <h4>Camarines Sur Polytechnic Colleges</h4>
            <p style="line-height: 0px;">San Miguel, Nabua, Camarines Sur</p>

            <h4>{{ $organization_code }} ({{ $organization_name }})</h4>
            <p style="line-height: 0px;">{{$text}} ELECTION RESULT {{ $year }}</p>
        </div>
        <div class="column" style="width: 20%; text-align:center;">
            <img src="{{ public_path('logo/uvote-logo.png') }}" alt="uVote logo" width="100" height="100">
        </div>
    </div>

    <hr>

    <div class="row" style="margin-top: 3px;">
        <div class="column" style="width: 50%; text-align:left;">
            <p><strong>Position / Name</strong></p>
        </div>
        <div class="column" style="width: 50%; text-align: right;">
            <p><strong>Votes Accomulated</strong></p>
        </div>
    </div>

    @foreach ($results as $positionName => $candidates)
        <div class="row" style="margin-top: 3px;">
            <div class="column" style="width: 100%; text-align:left;">
                <p style="text-decoration: underline;">{{ $positionName }}</p>
            </div>
        </div>
        @foreach ($candidates as $candidate)
            <div class="row">

                <div class="column" style="width: 90%; text-align:left;">
                    @if ($loop->first)
                    <p style="line-height: 0px; font-weight: bold;">
                        {{ $loop->index + 1 }}. {{ $candidate['candidate']->name }}
                    </p>
                    @else
                    <p style="line-height: 0px;">
                        {{ $loop->index + 1 }}. {{ $candidate['candidate']->name }}
                    </p>
                    @endif
                </div>
                <div class="column" style="width: 10%; text-align: center;">
                    @if($loop->first)
                    <p style="line-height: 0px; font-weight: bold;">
                        {{ $candidate['count'] }}</p>
                    @else
                    <p style="line-height: 0px;">
                            {{ $candidate['count'] }}</p>

                    @endif
                </div>
            </div>
        @endforeach
    @endforeach
</body>

</html>
