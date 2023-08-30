<?php

require __DIR__.'/vendor/autoload.php';

use App\Services\ApiCitybikDataParser;
use App\Services\BikersParser\BikersParserService;
use App\Services\ConsoleService;

try {
    if (isset($argv[1])) {

        $bikersCSVParserService = (new BikersParserService())->getServiceByFormat('CSV');
        $ApiCitybikDataParser = (new ApiCitybikDataParser($argv[1]));
        $console_service = new ConsoleService($bikersCSVParserService, $ApiCitybikDataParser);
        $console_service->showShortestDistancesFromStationsByCity();
    } else {
        echo "Enter the city";
    }
} catch (Error|Exception $e) {
    throw new Exception($e);
}





































