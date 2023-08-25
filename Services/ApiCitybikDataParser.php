<?php

namespace Services;

use Services\Decoders\ResponseValueDecoder;

class ApiCitybikDataParser
{
    protected string $base_url = 'https://api.citybik.es';
    protected string $api_endpoint_url = '/v2/networks';

    public function __construct(private readonly string $city = '')
    {
    }

    public function getHrefsByCity(): string
    {
        $response_from_api = $this->getParsedApiResponse();

        foreach ($response_from_api["networks"] as $network) {
            if ($network["location"]["city"] === $this->city) {
                $href = $network["href"];
            }
        }

        return $href;
    }

    private function getParsedApiResponse(): array
    {
        $api_content = file_get_contents($this->base_url . $this->api_endpoint_url);

        return (new Decoders\ResponseValueDecoder())->parseResponse($api_content);
    }

    public function getStationsData(): array
    {
        $hrefOfCity = $this->getHrefsByCity();

        $company_content = file_get_contents($this->base_url . $hrefOfCity);

        $response = (new ResponseValueDecoder())->parseResponse($company_content);

        foreach ($response["network"]["stations"] as $stat) {
            $stations_data[] = [
                "name"       => $stat["name"],
                "latitude"   => $stat["latitude"],
                "longitude"  => $stat["longitude"],
                "free_bikes" => $stat["free_bikes"]
            ];
        }

        return $stations_data;
    }
}