<?php

namespace App\Http\Controllers;

use App\WeatherData;
use Illuminate\Http\Request;
use App\Events\WeatherDataUpdate;

class WeatherDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $weatherData = WeatherData::whereRaw('created_at >= (NOW() - INTERVAL 24 HOUR)')->orderByDesc('created_at')->paginate(15);

        return view('welcome', compact('weatherData'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\WeatherData  $weatherData
     * @return \Illuminate\Http\Response
     */
    public function show(WeatherData $weatherData)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\WeatherData  $weatherData
     * @return \Illuminate\Http\Response
     */
    public function edit(WeatherData $weatherData)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\WeatherData  $weatherData
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WeatherData $weatherData)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\WeatherData  $weatherData
     * @return \Illuminate\Http\Response
     */
    public function destroy(WeatherData $weatherData)
    {
        //
    }

    public function weatherDataUpdated()
    {
        event(new WeatherDataUpdate(WeatherData::orderByDesc('created_at')->first()));

        return response('ok', 200);
    }
}
