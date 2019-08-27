<?php

namespace App\Http\Controllers;

use App\WeatherData;
use Illuminate\Http\Request;
use App\Events\WeatherDataUpdate;
use DB;
use Carbon\Carbon;

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

        $chartData = WeatherData::where('created_at', '>=', Carbon::now()->startOfDay()->subWeek())->whereRaw(DB::raw('(`id`) % 20 = 1'))->orderByDesc('created_at')->get(['created_at AS x', 'temperature AS y'])
        ->toJson();

        $avgData = collect(DB::select("SELECT
            ROUND(AVG(temperature), 1) AS y,
            DATE_FORMAT(FROM_UNIXTIME(AVG(UNIX_TIMESTAMP(created_at))), '%Y-%m-%d-%H:00:00') AS x
            FROM weather_data
            WHERE created_at >= CURDATE() - INTERVAL 7 DAY
            GROUP BY FLOOR(UNIX_TIMESTAMP(DATE_FORMAT(created_at - INTERVAL 6 HOUR,'%Y-%m-%d-%H:%i:00')) / 43200)"));

        $avgDayTemp = $avgData->nth(2, 1)->toJson();
        $avgNightTemp = $avgData->nth(2)->toJson();

        return view('welcome', compact('weatherData', 'chartData', 'avgDayTemp', 'avgNightTemp'));
    }

    private function getWeatherData()
    {
        $data = WeatherData::orderByDesc('created_at')->limit(15)->get();
        $data->each(function ($item) {
            $item->created_at_formatted = $item->created_at->format('H:i');
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
