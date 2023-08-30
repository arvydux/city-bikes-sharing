<?php

namespace App\Services\BikersParser;

class BikersParserService
{
    /**
     * @throws \Exception
     */
    public function getServiceByFormat(string $format): BikersParserInterface
    {
        try {
            $class_name = 'BikersParserFrom' . strtoupper($format);
            return (new (__NAMESPACE__ . '\\' . $class_name));
        } catch (\Exception) {
            throw new \Exception("BikersParserFrom' . stopper($format) . 'Service not found");
        }
    }
}