<?php

namespace GooberBlox\Web\Code;

class StaticBundleUtils
{
public static function computeHashForFiles(iterable $files, ?string $salt = null): string
    {
        $buffer = '';

        foreach ($files as $filePath) {
            $absolutePath = public_path(ltrim($filePath, '/'));

            try {
                if (!is_file($absolutePath)) {
                    throw new \RuntimeException("File not found: {$absolutePath}");
                }

                $buffer .= hash_file('sha256', $absolutePath, true);
            } catch (\Throwable $e) {
                report($e);
            }
        }

        if (!blank($salt)) {
            $buffer .= $salt;
        }

        return hash('sha256', $buffer);
    }
}