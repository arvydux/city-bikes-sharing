<?php

namespace App\Services\Decoders_delete;

interface Decoder
{
    public function decodeValue(string $decode_value, int &$i, int $n);
}