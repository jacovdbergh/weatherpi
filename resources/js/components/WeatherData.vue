<template>
    <div class="container">
            <div class="row">
                <div class="col-md-6 text-center">
                    <span>Temperature (℃)</span>
                    <h1 id="current_temp">{{latestTemperature}}</h1>
                </div>
                <div class="col-md-6 text-center">
                    <span>Humidity (%)</span>
                    <h1 id="current_humidity">{{latestHumidity}}</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-right">
                    <small id="reading_date">last updated: {{lastUpdated}}</small>
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
                            <tr v-for="data of weatherData" :key="data.id">
                                <td>{{data.created_at}}</td>
                                <td>{{data.sensor}}</td>
                                <td align="center">{{data.temperature}}</td>
                                <td align="center">{{data.humidity}}</td>
                            </tr>
                        </tbody>
                        </table>
                </div>
            </div>
    </div>
</template>

<script>
    export default {

        props: [
            'initialTemperature',
            'initialHumidity',
            'initialLastUpdated',
            'initialWeatherData'
        ],

        data() {
            return {
                latestTemperature: this.initialTemperature,
                latestHumidity: this.initialHumidity,
                lastUpdated: this.initialLastUpdated,
                weatherData: JSON.parse(this.initialWeatherData)
            }
        },

        mounted() {
            window.Echo.channel('private-weatherdata')
                .listen('WeatherDataUpdate', (event) => {
                    var data = event.weatherData.reverse();
                    this.latestTemperature = data[0].temperature;
                    this.latestHumidity = data[0].humidity;
                    this.lastUpdated = (data[0].created_at).substring(11, 16);
                    this.weatherData = data;
                });
        }
    }
</script>
