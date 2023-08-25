<?php

namespace Services\BikersParser;

class BikersParserService
{
    /**
     * @throws \Exception
     */
    public function parse(string $format = 'CSV'): array
    {
        try {
            $class_name = 'BikersParserFrom' . strtoupper($format);
            return (new ("Services\\BikersParser\\" . $class_name))->parse();
        } catch (\Exception) {
            throw new \Exception("BikersParserFrom' . stopper($format) . 'Service not found");
        }
    }
}