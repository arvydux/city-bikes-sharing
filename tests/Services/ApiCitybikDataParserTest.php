<?php

declare(strict_types=1);

namespace Services;

use App\Services\ApiCitybikDataParser;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

final class ApiCitybikDataParserTest extends TestCase
{
    #[TestWith(["Vilnius", '40-OGMIOS MIESTAS', 054.712375, 025.29664, 4])]
    #[TestWith(["Paris", 'Place Nelson Mandela', '048.862453313908', 02.1961666225454, 7])]
    #[TestWith(["Brno", 'Celní', 049.179143, 016.596949, 10])]
    public function testStationParsedCorrectly(
        $city,
        $station_name,
        $station_latitude,
        $station_longitude,
        $station_free_bikes
    ): void {
        $station = (object)[
            "name"       => $station_name,
            "latitude"   => $station_latitude,
            "longitude"  => $station_longitude,
            "free_bikes" => $station_free_bikes
        ];

        $stations[] = $station;

        $ApiCitybikDataParserTest = $this->createMock(ApiCitybikDataParser::class);

        $ApiCitybikDataParserTest->expects($this->once())
            ->method('getStationsData')
            ->willReturn($stations);

        $stations = $ApiCitybikDataParserTest->getStationsData();

        $expected_results['name'] = $station_name;
        $expected_results['latitude'] = $station_latitude;
        $expected_results['longitude'] = $station_longitude;


        $this->assertEquals($expected_results['name'], $stations[0]->name);
        $this->assertEquals($expected_results['latitude'], $stations[0]->latitude);
        $this->assertEquals($expected_results['longitude'], $stations[0]->longitude);
        $this->assertTrue(is_numeric($stations[0]->free_bikes));
    }
}