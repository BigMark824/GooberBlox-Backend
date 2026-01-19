<?php

namespace GooberBlox\Web\SEO;

class NameConverter
{
    public static function convertToSEO(string $input): string
    {
        $output = '';
        $length = strlen($input);

        for ($i = 0; $i < $length; $i++) {
            $char = $input[$i];
            if (!ctype_alnum($char)) {
                continue;
            }

            $start = $i;

            for (; $i < $length; $i++) {
                $char = $input[$i];

                if ($char === "'") {
                    $output .= substr($input, $start, $i - $start);
                    $start = $i + 1;
                } elseif (!ctype_alnum($char)) {
                    break;
                }
            }

            $output .= substr($input, $start, $i - $start);
            $output .= "-";
        }

        $output = rtrim($output, "-");

        if ($output === '') {
            return 'unnamed';
        }

        return $output;
    }
}
