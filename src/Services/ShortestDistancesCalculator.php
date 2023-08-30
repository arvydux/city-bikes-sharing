<?php

namespace App\Services;

class ShortestDistancesCalculator
{
    public function __construct(private readonly DistanceCalculator $distanceCalculator)
    {
    }

    public function getShortestDistancesFromStationToBikers(array $bikers, array $stations): array
    {
        $shortest_distances = [];
        foreach ($bikers as $biker) {
            $shortest_distance = 9999999999999999;
            $closest_station_name = '';
            $free_bike_count = 0;
            $biker_count = 0;
            foreach ($stations as $station) {
                $distance = $this->distanceCalculator->getDistance(
                    $station["latitude"],
                    $station["longitude"],
                    $biker["latitude"],
                    $biker["longitude"]
                );
                if ($distance < $shortest_distance) {
                    $shortest_distance = $distance;
                    $closest_station_name = $station["name"];
                    $free_bike_count = $station["free_bikes"];
                    $biker_count = $biker["count"];
                }
            }

            $shortest_distances[] = [
                "name"            => $closest_station_name,
                "distance"        => $shortest_distance,
                "free_bike_count" => $free_bike_count,
                "biker_count"     => $biker_count
            ];
        }

        return $shortest_distances;
    }
}