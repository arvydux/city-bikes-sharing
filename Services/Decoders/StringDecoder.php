<?php

namespace Services\Decoders;

use Exception;

class StringDecoder extends ResponseValueDecoder implements Decoder
{
    /**
     * @throws Exception
     */
    public function decodeValue(string $string, int &$i, $n): string
    {
        $result = '';
        $n = strlen($string);
        if ($string[$i] === '"') {
            while (++$i < $n) {
                if ($string[$i] === '"') {
                    $i++;

                    return $result;
                }
                if ($string[$i] === '\\') {
                    $this->decodeEscapedValue($string, $i, $result);
                } else {
                    $result .= $string[$i];
                }
            }
        }
        throw new Exception("Syntax error string decoder");
    }

    private function decodeEscapedValue(string $string, int &$i, string &$result): void
    {
        $i++;
        $escape = array(
            '"'  => '"',
            '\\' => '\\',
            '/'  => '/',
            'b'  => "\b",
            'f'  => "\f",
            'n'  => "\n",
            'r'  => "\r",
            't'  => "\t"
        );
        if ($string[$i] === 'u') {
            $this->decodeUnicodeValue($string, $i, $result);
        } elseif (isset($escape[$string[$i]])) {
            $result .= $escape[$string[$i]];
        }
    }

    private function decodeUnicodeValue(string $string, int &$i, string &$result): void
    {
        $code = "&#" . hexdec(substr($string, $i + 1, 4)) . ";";
        $convmap = array(0x80, 0xFFFF, 0, 0xFFFF);
        $result .= mb_decode_numericentity($code, $convmap, 'UTF-8');
        $i += 4;
    }
}