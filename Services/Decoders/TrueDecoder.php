<?php

namespace Services\Decoders;

class TrueDecoder extends ResponseValueDecoder implements Decoder
{
    public function decodeValue(string $decode_value, int &$i, int $n)
    {
        if ($i + 3 < $n && substr($decode_value, $i, 4) === 'true') {
            $i += 4;

            return true;
        }
    }
}