<?php

namespace Services;

use Services\BikersParser\BikersParserService;

class DistanceCalculator
{
    private const EARTH_RADIUS = 6371;

    public function __construct(
        private readonly BikersParserService $bikers_parser,
        private readonly ApiCitybikDataParser $api_citybik_data_parser
    ) {
    }

    public function getShortestDistancesFromStationToBikersData(): array
    {
        $bikers = $this->bikers_parser->parse("CSV");
        $stations = $this->api_citybik_data_parser->getStationsData();

        return $this->calculateShortestDistancesFromStationToBikers($bikers, $stations);
    }

    private function calculateShortestDistancesFromStationToBikers(array $bikers, array $stations): array
    {
        $shortest_distances = [];
        foreach ($bikers as $biker) {
            $shortest_distance = 9999999999999999;
            $closest_station_name = '';
            $free_bike_count = 0;
            $biker_count = 0;
            foreach ($stations as $station) {
                $distance = $this->getDistance(
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

    private function getDistance(float $latitude1, float $longitude1, float $latitude2, float $longitude2): float
    {
        $dLat = deg2rad($latitude2 - $latitude1);
        $dLon = deg2rad($longitude2 - $longitude1);

        $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * sin(
                $dLon / 2
            ) * sin($dLon / 2);
        $c = 2 * asin(sqrt($a));

        return static::EARTH_RADIUS * $c;
    }
}