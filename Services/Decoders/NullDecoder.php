<?php

namespace Services\Decoders;

class NullDecoder extends ResponseValueDecoder implements Decoder
{
    public function decodeValue(string $decode_value, int &$i, int $n)
    {
        if ($i + 3 < $n && substr($decode_value, $i, 4) === 'null') {
            $i += 4;

            return null;
        }
    }
}