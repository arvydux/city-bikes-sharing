<?php

namespace App\Services\BikersParser;

class BikersParserService
{
    /**
     * @throws \Exception
     */
    public function parse(string $format = 'CSV'): array
    {
        try {
            $class_name = 'BikersParserFrom' . strtoupper($format);
            return (new (__NAMESPACE__ . '\\' . $class_name))->parse();
        } catch (\Exception) {
            throw new \Exception("BikersParserFrom' . stopper($format) . 'Service not found");
        }
    }
}