<?php

namespace App\Services\Decoders;

use Error;

class ResponseValueDecoder
{
    public function parseResponse(string $response): mixed
    {
        mb_internal_encoding("UTF-8");
        $i = 0;
        $n = strlen($response);
        try {
            $result = $this->responseDecodeValue($response, $i);
            $this->moveToNextValue($response, $i, $n);
            if ($i < $n) {
                return null;
            }

            return $result;
        } catch (Error $e) {
            echo $e->getMessage();
        }
    }

    protected function responseDecodeValue(string $decode_value, int &$i): mixed
    {
        $n = strlen($decode_value);
        $this->moveToNextValue($decode_value, $i, $n);

        $decoder_types = [
            '{' => 'ObjectDecoder',
            '[' => 'ArrayDecoder',
            '"' => 'StringDecoder',
            '-' => 'NumberDecoder',
            't' => 'TrueDecoder',
            'f' => 'FalseDecoder',
            'n' => 'NullDecoder',
        ];

        $this->moveToNextValue($decode_value, $i, $n);

        try {
            if (!array_key_exists($decode_value[$i], $decoder_types)) {
                return (new DefaultDecoder)->decodeValue($decode_value, $i, $n);
            }

            return (new ('App\\Services\\Decoders\\' . $decoder_types[$decode_value[$i]]))->decodeValue(
                $decode_value,
                $i,
                $n
            );
        } catch (Error $e) {
            throw new Error("Certain decoder service is missing");
        }
    }

    protected function moveToNextValue(string $decode_value, int &$i, int $n): void
    {
        while ($i < $n && $decode_value[$i] && $decode_value[$i] <= ' ') {
            $i++;
        }
    }
}