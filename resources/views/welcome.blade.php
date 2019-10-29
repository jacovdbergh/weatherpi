@extends('layouts.app')

@section('content')
<br>
<br>
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <weatherdata
                initial-temperature="{{$weatherData[0]->temperature}}"
                initial-humidity="{{$weatherData[0]->humidity}}"
                initial-last-updated="{{$weatherData[0]->created_at->format('H:i')}}"
                initial-weather-data="{{json_encode($weatherData)}}">
            </weatherdata>
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-12">
                    <br>
                    <canvas id="temperature-chart"></canvas>
                </div>
                <div class="col-md-12">
                    <br>
                    <canvas id="avg-chart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    window.chartColors = {
        red: 'rgb(255, 99, 132)',
        orange: 'rgb(255, 159, 64)',
        yellow: 'rgb(255, 205, 86)',
        green: 'rgb(75, 192, 192)',
        blue: 'rgb(54, 162, 235)',
        purple: 'rgb(153, 102, 255)',
        grey: 'rgb(201, 203, 207)'
    };

    var timeFormat = 'YYY/MM/DD HH:mm';

    var color = Chart.helpers.color;
    var config = {
        type: 'line',
        data: {
            label: 'Temperature',
            datasets: [{
                label: 'Temperature',
                backgroundColor: color(window.chartColors.red).alpha(0.5).rgbString(),
                borderColor: window.chartColors.red,
                fill: false,
                data: JSON.parse('{!!$chartData!!}'),
            }]
        },
        options: {
            title: {
                text: 'Weather PI temparture charts'
            },
            scales: {
                xAxes: [{
                    type: 'time',
                    time: {
                        parser: timeFormat,
                        // round: 'day'
                        tooltipFormat: 'MMM D HH:mm',
                        unit: 'day',
                        displayFormats: {
                            day: 'MMM D',
                          }
                    },
                    scaleLabel: {
                        display: true,
                        labelString: 'Date'
                    }
                }],
                yAxes: [{
                    scaleLabel: {
                        display: true,
                        labelString: 'Degrees Celsius'
                    }
                }]
            },
        }
    };
    var avgConfig = {
        type: 'line',
        data: {
            label: 'Average Temperatures',
            datasets: [{
                label: 'Avg day temp',
                backgroundColor: color(window.chartColors.red).alpha(0.5).rgbString(),
                borderColor: window.chartColors.red,
                fill: false,
                data: JSON.parse('{!!$avgDayTemp!!}'),
            },                
            {
                label: 'Avg night temp',
                backgroundColor: color(window.chartColors.blue).alpha(0.5).rgbString(),
                borderColor: window.chartColors.blue,
                fill: false,
                data: JSON.parse('{!!$avgNightTemp!!}'),
            }]
        },
        options: {
            title: {
                text: 'Weather PI average temp charts'
            },
            scales: {
                xAxes: [{
                    type: 'time',
                    time: {
                        parser: timeFormat,
                        // round: 'day'
                        tooltipFormat: 'MMMM D',
                        unit: 'day',
                        displayFormats: {
                            day: 'MMM D',
                          }
                    },
                    scaleLabel: {
                        display: true,
                        labelString: 'Date'
                    }
                }],
                yAxes: [{
                    scaleLabel: {
                        display: true,
                        labelString: 'Degrees Celsius'
                    }
                }]
            },
        }
    };

    window.onload = function() {
        var ctx = document.getElementById('temperature-chart').getContext('2d');
        window.myLine = new Chart(ctx, config);

        var ctx = document.getElementById('avg-chart').getContext('2d');
        window.myLine = new Chart(ctx, avgConfig);

    };
</script>
@endsection
