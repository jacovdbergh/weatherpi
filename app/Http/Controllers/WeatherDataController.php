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
        $weatherData = $this->getWeatherData();

        return view('welcome', compact('weatherData'));
    }

    private function getWeatherData()
    {
        $data = WeatherData::orderByDesc('created_at')->limit(15)->get();
        $data->each(function ($item) {
            $item->created_at_formatted = $item->created_at->format('H:i') . ' ('.$item->created_at->diffForHumans().')';
        });

        return $data;
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
        $weatherData = $this->getWeatherData();

        event(new WeatherDataUpdate($weatherData));

        return response('ok', 200);
    }

    public function takeReading()
    {
        shell_exec('sudo -u pi python /home/pi/DHT22-TemperatureLogger/DHT22logger.py');

        return response('ok', 200);
    }
}
