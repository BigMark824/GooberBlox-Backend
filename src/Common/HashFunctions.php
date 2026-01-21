<?php

namespace GooberBlox\Common;

class HashFunctions
{
    public static function hashToString(string $rawHash): string
    {
        return bin2hex($rawHash);
    }

    public static function computeHashFromStream($stream): string
    {
        $context = hash_init('md5');
        $position = ftell($stream);

        rewind($stream);
        hash_update_stream($context, $stream);

        fseek($stream, $position);

        return hash_final($context, true);
    }

    public static function computeHash(string $data): string
    {
        return hash('md5', $data, true);
    }

    public static function computeHashString(string $data): string
    {
        return bin2hex(self::computeHash($data));
    }

    public static function computeHashStringFromStream($stream): string
    {
        return bin2hex(self::computeHashFromStream($stream));
    }

    public static function computeMd5HashString(string $input): string
    {
        return strtoupper(md5($input));
    }
}