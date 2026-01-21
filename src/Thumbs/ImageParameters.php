<?php

namespace GooberBlox\Thumbs;

class ImageParameters
{
    public static function GetMimeType(string $format)
    {
        switch($format)
        {
            case "Jpeg":
                return "image/jpg";
            case "Png":
                return "image/png";
            case "Bmp":
                return "image/bmp";
            case "Gif":
                return "image/gif";
            case "Tiff":
                return "image/tiff";
            default:
                return "image";
        }
    }
}