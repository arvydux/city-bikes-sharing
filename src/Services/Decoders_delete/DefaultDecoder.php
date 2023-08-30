<?php

namespace App\Services\Decoders_delete;

use Error;

class DefaultDecoder extends ResponseValueDecoder implements Decoder
{
    public function decodeValue(string $decode_value, int &$i, int $n): string
    {
        if ($decode_value[$i] >= '0' && $decode_value[$i] <= '9') {
            return (new NumberDecoder())->decodeValue($decode_value, $i, $n);
        }
        throw new Error("Syntax error in default decoder detected");
    }
}