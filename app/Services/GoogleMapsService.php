<?php

namespace App\Services;

class GoogleMapsService
{
    /**
     * Mockup for Distance Matrix API
     */
    public function estimateDeliveryCostAndTime($lat1, $lng1, $lat2, $lng2, $method = 'motocicleta')
    {
        // Simple euclidean mockup
        $distanceKm = sqrt(pow(($lat2 - $lat1), 2) + pow(($lng2 - $lng1), 2)) * 111;
        
        $speeds = [
            'dron' => 45, // km/h
            'bicicleta' => 15,
            'motocicleta' => 30
        ];

        $costs = [
            'dron' => 50, // base cost
            'bicicleta' => 10,
            'motocicleta' => 20
        ];

        $speed = $speeds[$method] ?? 30;
        $timeInHours = $distanceKm / $speed;
        $timeInMinutes = max(10, round($timeInHours * 60)); // minimum 10 min
        
        $baseCost = $costs[$method] ?? 20;
        $totalCost = $baseCost + ($distanceKm * ($baseCost * 0.1));

        return [
            'distance_km' => round($distanceKm, 2),
            'estimated_time_minutes' => $timeInMinutes,
            'cost' => round($totalCost, 2)
        ];
    }
}
