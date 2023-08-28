<?php

namespace App\Services\BikersParser;

class BikersParserFromCSV implements BikersParserInterface
{
    private string $file_name = 'bikers.csv';

    public function parse(): array
    {
        $bikers = [];
        $handle = fopen($this->file_name, "r");
        if ($handle) {
            $i = 0;
            while (($line = fgets($handle)) !== false) {
                $i++;
                if ($i === 1) {
                    continue;
                } else {
                    $biker_info = explode(",", $line);
                    $bikers[] = [
                        "count"     => $biker_info[0],
                        "latitude"  => $biker_info[1],
                        "longitude" => $biker_info[2],
                    ];
                }
            }

            fclose($handle);
        }

        return $bikers;
    }
}