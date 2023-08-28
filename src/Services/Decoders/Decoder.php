<?php

namespace App\Services\Decoders;

interface Decoder
{
    public function decodeValue(string $decode_value, int &$i, int $n);
}