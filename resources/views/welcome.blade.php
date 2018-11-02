<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        <script type="text/javascript" src="http://vdbergh.dynu.com:6001/socket.io/socket.io.js"></script>
        <script src="{{ mix('js/app.js') }}"></script>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <br>
            <br>
            <div class="container">
                <div class="col-md-6 offset-md-3">
                    <div class="row">
                        <div class="col-md-6 text-center">
                            <span>Temperature (℃)</span>
                            <h1 id="current_temp">{{$weatherData[0]->temperature}}</h1>
                        </div>
                        <div class="col-md-6 text-center">
                            <span>Humidity (%)</span>
                            <h1 id="current_humidity">{{$weatherData[0]->humidity}}</h1>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-right">
                            <small id="reading_date">last updated: {{$weatherData[0]->created_at->format('H:i')}}</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                                <hr>
                            <table class="table table-dark table-sm table-bordered">
                                <thead>
                                    <tr>
                                        <th>Time</th>
                                        <th>Sensor</th>
                                        <th>Temperature (℃)</th>
                                        <th>Humidity (%)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($weatherData as $data)                    
                                        <tr>
                                            <td>{{$data->created_at->diffForHumans()}}</td>
                                            <td>{{$data->sensor}}</td>
                                            <td align="center">{{$data->temperature}}</td>
                                            <td align="center">{{$data->humidity}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                </table>
                                {{$weatherData->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>

<script>
    window.Echo.channel('private-weatherdata')
    .listen('WeatherDataUpdate', (event) => {
        console.log(event);

        $('#current_temp').html(event.weatherData.temperature);
        $('#current_humidity').html(event.weatherData.humidity);
        $('#reading_date').html('last updated: ' + (event.weatherData.created_at).substring(11, 16));

    });
</script>
