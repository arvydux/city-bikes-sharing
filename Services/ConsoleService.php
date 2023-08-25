<?php

namespace Services;

use Services\BikersParser\BikersParserService;

class ConsoleService
{
    public function showShortestDistancesFromStationsByCity(?string $city): void
    {
        if ($this->isValidInput($city)) {
            $distance_calculator = new DistanceCalculator(new BikersParserService(), new ApiCitybikDataParser($city));
            $shortest_distances = $distance_calculator->getShortestDistancesFromStationToBikersData();

            foreach ($shortest_distances as $shortest_distance) {
                echo "distance: " . $shortest_distance["distance"] . PHP_EOL;
                echo "station name: " . $shortest_distance["name"] . PHP_EOL;
                echo "free bike count: " . $shortest_distance["free_bike_count"] . PHP_EOL;
                echo "biker count: " . $shortest_distance["biker_count"] . PHP_EOL;
                echo PHP_EOL;
                echo PHP_EOL;
            }
        } else {
            $city = readline("City was not found or entered incorrectly. Try to enter again ");
            $this->showShortestDistancesFromStationsByCity($city);
        }
    }

    private function isValidInput(?string $city): bool
    {
        $city = ucfirst(strtolower($city));
        $hrefs_of_cities = (new ApiCitybikDataParser($city))->getHrefsByCity();

        return !(empty($hrefs_of_cities));
    }
}