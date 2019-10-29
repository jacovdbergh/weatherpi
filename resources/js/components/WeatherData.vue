<template>
    <div class="container">
            <div class="row">
                <div class="col-md-4 text-center">
                    <span>Temperature (℃)</span>
                    <h1 id="current_temp">{{latestTemperature}}</h1>
                </div>
                <div class="col-md-4 text-center">
                    <span>Humidity (%)</span>
                    <h1 id="current_humidity">{{latestHumidity}}</h1>
                </div>
                <div class="col-md-4 text-center">
                    <span>Power Usage (W)</span>
                    <h1 id="current_humidity">{{initialPower}}</h1>
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
                                <th>Temperature (℃)</th>
                                <th>Humidity (%)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="data of weatherData" :key="data.id">
                                <td>{{data.created_at_formatted}}</td>
                                <td align="center">{{data.temperature}}</td>
                                <td align="center">{{data.humidity}}</td>
                            </tr>
                        </tbody>
                        </table>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 text-center">
                    <button class="btn btn-primary" v-on:click="updateData">Update</button>
                </div>
            </div>
    </div>
</template>

<script>
    export default {

        props: [
            'initialTemperature',
            'initialPower',
            'initialHumidity',
            'initialLastUpdated',
            'initialWeatherData',
        ],

        data() {
            return {
                latestTemperature: this.initialTemperature,
                latestHumidity: this.initialHumidity,
                lastUpdated: this.initialLastUpdated,
                weatherData: JSON.parse(this.initialWeatherData)
            }
        },

        methods: {
            updateData: function (event) {
                axios.get('/take-reading');
            }
        },

        mounted() {
            window.Echo.channel('private-weatherdata')
                .listen('WeatherDataUpdate', (event) => {
                    var data = event.weatherData;
                    this.latestTemperature = data[0].temperature;
                    this.latestHumidity = data[0].humidity;
                    this.lastUpdated = (data[0].created_at).substring(11, 16);
                    this.weatherData = data;
                });
        }
    }
</script>
