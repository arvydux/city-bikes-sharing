<?php

namespace App\Services\Decoders;

class NumberDecoder extends ResponseValueDecoder implements Decoder
{
    public function decodeValue(string $number, int &$i, $n): string
    {
        $result = '';
        if ($number[$i] === '-') {
            $result = '-';
            $i++;
        }
        $n = strlen($number);
        $this->addNumberToResult($number, $i, $n, $result);

        if ($i < $n && $number[$i] === '.') {
            $result .= '.';
            $i++;
            $this->addNumberToResult($number, $i, $n, $result);
        }
        if ($i < $n && ($number[$i] === strtoupper('e'))) {
            $result .= $number[$i];
            $i++;
            if ($number[$i] === '-' || $number[$i] === '+') {
                $result .= $number[$i++];
            }
            $this->addNumberToResult($number, $i, $n,$result);
        }

        return (0 . $result);
    }

    private function addNumberToResult(string $number, int &$i, int $n, string &$result): void
    {
        while ($i < $n && $number[$i] >= '0' && $number[$i] <= '9') {
            $result .= $number[$i++];
        }
    }
}