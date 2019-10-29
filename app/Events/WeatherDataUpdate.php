<?php

namespace App\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Support\Collection;
use App\WeatherData;

class WeatherDataUpdate implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets;

    public $weatherData;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Collection $weatherData)
    {
        $this->weatherData = $weatherData;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('weatherdata');
    }
}
