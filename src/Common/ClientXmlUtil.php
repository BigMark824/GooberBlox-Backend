<?php

namespace GooberBlox\Common;

class ClientXmlUtil
{
    public static function generateXmlTable(iterable $entries): string
    {
        $xml = "<Value><Table>";
        foreach ($entries as $key => $value) {
            $xml .= "<Entry><Key>{$key}</Key><Value>{$value}</Value></Entry>";
        }

        return $xml . '</Table></Value>';
    }

    public static function generateXmlList(iterable $entries): string
    {
        $xml = "<List>";
        foreach($entries as $entry) 
        {
            $xml .= "<Value>{$entry}</Value>";
        }

        return $xml . "</List>";
    }

    public static function generateXmlBool(bool $value): string
    {
        return sprintf("<Value Type=\"boolean\">%s</Value>", $value ?"true":"false");
    }

    public static function generateXmlString(string $value): string
    {
        return "<Value>{$value}</Value>";
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