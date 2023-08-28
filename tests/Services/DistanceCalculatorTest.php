<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Services\ApiCitybikDataParser;
use App\Services\BikersParser\BikersParserService;
use App\Services\DistanceCalculator;

final class DistanceCalculatorTest extends TestCase
{
    public function testReturnCorrectDistanceCalculations(): void
    {
        $city = "Vilnius";
        $precision = 6;

        $distance_calculator = new DistanceCalculator(new BikersParserService(), new ApiCitybikDataParser($city));
        $shortest_distances = $distance_calculator->getShortestDistancesFromStationToBikersData();

        $distances_to_bikers = [
            round($shortest_distances[0]['distance'], $precision),
            round($shortest_distances[1]['distance'], $precision),
            round($shortest_distances[2]['distance'], $precision),
            round($shortest_distances[3]['distance'], $precision),
        ];

        $expected_results = [
            round(1488.7120093641, $precision),
            round(1488.383384397,  $precision),
            round(1489.0386030284, $precision),
            round(1483.6949062809, $precision),
        ];

        $this->assertEquals($distances_to_bikers, $expected_results, "");
    }
}