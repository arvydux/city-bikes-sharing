<?php

namespace App\Services\Decoders_delete;

use Exception;

class ObjectDecoder extends ResponseValueDecoder implements Decoder
{
    /**
     * @throws Exception
     */
    public function decodeValue(string $decode_value, int &$i, int $n): array
    {
        $i++;
        $result = [];
        $this->moveToNextValue($decode_value, $i, $n,);
        if ($decode_value[$i] === '}') {
            $i++;

            return $result;
        }
        while ($i < $n) {
            $key = (new StringDecoder())->decodeValue($decode_value, $i, $n);
            $this->moveToNextValue($decode_value, $i, $n,);
            if ($decode_value[$i++] != ':') {
                throw new Exception("Expected ':' on " . ($i - 1));
            }
            $result[$key] = $this->responseDecodeValue($decode_value, $i);
            $this->moveToNextValue($decode_value, $i, $n,);
            if ($decode_value[$i] === '}') {
                $i++;

                return $result;
            }
            if ($decode_value[$i++] != ',') {
                throw new Exception("Expected ',' on " . ($i - 1));
            }
            $this->moveToNextValue($decode_value, $i, $n,);
        }
        throw new Exception("Syntax error");
    }
}