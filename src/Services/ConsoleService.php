<?php

namespace App\Services;

use App\Services\BikersParser\BikersParserService;

class ConsoleService
{
    public function __construct(private string $city)
    {
    }

    public function showShortestDistancesFromStationsByCity(): void
    {
        if ($this->isValidInput()) {
            $distance_calculator = new DistanceCalculator(new BikersParserService(), new ApiCitybikDataParser($this->city));
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
            $this->city = readline("City was not found or entered incorrectly. Try to enter again ");
            $this->showShortestDistancesFromStationsByCity();
        }
    }

    private function isValidInput(): bool
    {
        $this->city = ucfirst(strtolower($this->city));
        $hrefs_of_cities = (new ApiCitybikDataParser($this->city))->getHrefsByCity();

        return !(empty($hrefs_of_cities));
    }
}