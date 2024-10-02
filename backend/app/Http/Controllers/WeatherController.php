<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\Forecast;
use Illuminate\Support\Facades\Http;

class WeatherController extends Controller
{
    public function addLocation(Request $request)
    {
        $request->validate([
            'city' => 'required|string',
            'state' => 'required|string',
        ]);

        $user = $request->user();

        if ($user->locations()->count() >= 3) {
            return response()->json(['message' => 'You can only register up to 3 locations.'], 403);
        }

        $location = Location::create([
            'user_id' => $user->id,
            'city' => $request->city,
            'state' => $request->state,
        ]);

        $this->fetchForecast($location);

        return response()->json(['message' => 'Location added successfully.']);
    }

    public function removeLocation($id)
    {
        $user = request()->user();
        $location = $user->locations()->findOrFail($id);
        $location->delete();

        return response()->json(['message' => 'Location removed successfully.']);
    }

    public function getLocations()
    {
        $user = request()->user();
        $locations = $user->locations()->with('forecasts')->get();

        return response()->json($locations);
    }

    private function fetchForecast(Location $location)
    {
        $apiKey = env('OPENWEATHERMAP_API_KEY');

        $response = Http::get('https://api.openweathermap.org/data/2.5/forecast', [
            'q' => "{$location->city},{$location->state},US",
            'units' => 'metric',
            'appid' => $apiKey,
        ]);

        if ($response->successful()) {
            $data = $response->json();

            // Save forecast for the next 2 days
            $forecasts = [];
            foreach ($data['list'] as $item) {
                $date = substr($item['dt_txt'], 0, 10);
                if (count($forecasts) >= 2) break;

                if (!isset($forecasts[$date])) {
                    $forecasts[$date] = [
                        'location_id' => $location->id,
                        'date' => $date,
                        'min_temp' => $item['main']['temp_min'],
                        'max_temp' => $item['main']['temp_max'],
                        'condition' => $item['weather'][0]['main'],
                        'icon' => $item['weather'][0]['icon'],
                    ];
                }
            }

            // Save forecasts to the database
            foreach ($forecasts as $forecastData) {
                Forecast::create($forecastData);
            }
        }
    }
}
