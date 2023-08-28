<?php

declare(strict_types=1);

use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;
use App\Services\ApiCitybikDataParser;

final class ApiCitybikDataParserTest extends TestCase
{
    #[TestWith(["Vilnius", '40-OGMIOS MIESTAS', 054.712375, 025.29664])]
    #[TestWith(["Paris", 'Place Nelson Mandela', '048.862453313908', 02.1961666225454])]
    #[TestWith(["Brno", 'Celní', 049.179143, 016.596949])]
    public function testStationParsedCorrectly(
        $city,
        $station_name,
        $station_latitude,
        $station_longitude
    ): void {
        $ApiCitybikDataParserTest = new ApiCitybikDataParser($city);
        $stations = $ApiCitybikDataParserTest->getStationsData();

        $expected_results['name'] = $station_name;
        $expected_results['latitude'] = $station_latitude;
        $expected_results['longitude'] = $station_longitude;

        foreach ($stations as $station) {
            $result = in_array($expected_results['latitude'], $station);
            if ($result) {
                break;
            } else {
                $station = [];
            }
        }

        $this->assertEquals($expected_results['name'], $station['name']);
        $this->assertEquals($expected_results['latitude'], $station['latitude']);
        $this->assertEquals($expected_results['longitude'], $station['longitude']);
        $this->assertTrue(is_numeric($station['free_bikes']));
    }
}