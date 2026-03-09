<?php

namespace GooberBlox\Common;

class ClientXmlUtil
{
    private static function escape(string $value): string
    {
        return htmlspecialchars($value, ENT_XML1 | ENT_COMPAT, 'UTF-8');
    }

    public static function generateXmlTable(iterable $entries): string
    {
        $xml = "<Value><Table>";

        foreach ($entries as $key => $value) {
            $key = self::escape((string)$key);
            $value = self::escape((string)$value);

            $xml .= "<Entry><Key>{$key}</Key><Value>{$value}</Value></Entry>";
        }

        return $xml . "</Table></Value>";
    }

    public static function generateXmlList(iterable $entries): string
    {
        $xml = "<List>";

        foreach ($entries as $entry) {
            $entry = self::escape((string)$entry);
            $xml .= "<Value>{$entry}</Value>";
        }

        return $xml . "</List>";
    }

    public static function generateXmlBool(bool $value): string
    {
        return '<Value Type="boolean">' . ($value ? 'true' : 'false') . '</Value>';
    }

    public static function generateXmlString(string $value): string
    {
        return '<Value>' . self::escape($value) . '</Value>';
    }

    public static function generateXmlInteger(int $value): string
    {
        return "<Value Type=\"integer\">{$value}</Value>";
    }

    public static function generateXmlDouble(float $value): string
    {
        return "<Value Type=\"number\">{$value}</Value>";
    }
}