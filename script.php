<?php

require_once 'script_autoload.php';

use Services\ConsoleService;

try {
    if (isset($argv[1])) {
        $console_service = new ConsoleService();
        $console_service->showShortestDistancesFromStationsByCity($argv[1]);
    } else {
        echo "Enter the city";
    }
} catch (Error|Exception $e) {
    throw new Exception($e);
}





































