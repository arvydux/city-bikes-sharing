<?php

require_once 'script_autoload.php';

use Services\ConsoleService;

try {
    if (isset($argv[1])) {
        $console_service = new ConsoleService($argv[1]);
        $console_service->showShortestDistancesFromStationsByCity();
    } else {
        echo "Enter the city";
    }
} catch (Error|Exception $e) {
    throw new Exception($e);
}





































