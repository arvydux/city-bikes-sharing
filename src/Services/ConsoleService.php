<?php

namespace App\Services;

use App\Services\BikersParser\BikersParserInterface;

class ConsoleService
{
    public function __construct(
        private readonly BikersParserInterface $bikersParserService,
        private readonly ApiCitybikDataParser $apiCitybikDataParser
    ) {
    }

    public function showShortestDistancesFromStationsByCity(): void
    {
        if ($this->isValidInput()) {
            $shortest_distances_calculator = new ShortestDistancesCalculator(new DistanceCalculator());
            $shortest_distances = $shortest_distances_calculator->getShortestDistancesFromStationToBikers(
                $this->bikersParserService->parse(),
                $this->apiCitybikDataParser->getStationsData(),
            );

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
        $hrefs_of_cities = $this->apiCitybikDataParser->getHrefsByCity();

        return !(empty($hrefs_of_cities));
    }
}