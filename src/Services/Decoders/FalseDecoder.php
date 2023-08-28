<?php

namespace App\Services\Decoders;

class FalseDecoder extends ResponseValueDecoder implements Decoder
{
    public function decodeValue(string $decode_value, int &$i, int $n)
    {
        if ($i + 4 < $n && substr($decode_value, $i, 5) === 'false') {
            $i += 5;

            return false;
        }
    }
}