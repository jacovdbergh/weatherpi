@extends('layouts.app')

@section('content')
<br>
<br>
<div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <weatherdata
                initial-temperature="{{$weatherData[0]->temperature}}"
                initial-humidity="{{$weatherData[0]->humidity}}"
                initial-last-updated="{{$weatherData[0]->created_at->format('H:i')}}"
                initial-weather-data="{{json_encode($weatherData->items())}}">
            </weatherdata>
        </div>
    </div>
</div>
@endsection
