<?php

namespace Services\Decoders;

use Exception;

class ArrayDecoder extends ResponseValueDecoder implements Decoder
{
    /**
     * @throws Exception
     */
    public function decodeValue(string $decode_value, int &$i, int $n): array
    {
        $i++;
        $result = [];

        $this->moveToNextValue($decode_value, $i, $n,);
        if ($this->isObjectClosedBracket($decode_value, $i)) {
            $i++;

            return [];
        }
        while ($i < $n) {
            $result[] = $this->responseDecodeValue($decode_value, $i);
            $this->moveToNextValue($decode_value, $i, $n,);
            if ($this->isObjectClosedBracket($decode_value, $i)) {
                $i++;

                return $result;
            }
            if ($decode_value[$i++] != ',') {
                throw new Exception("Expected ',' on " . ($i - 1));
            }
            $this->moveToNextValue($decode_value, $i, $n,);
        }
        throw new Exception("Syntax error in array decoder");
    }

    private function isObjectClosedBracket(string $decode_value, int $i): bool
    {
        return $decode_value[$i] === ']';
    }

}