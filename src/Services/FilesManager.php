<?php

namespace GooberBlox\Services;

// TODO: More work on this, this is great for now though. 
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

use GooberBlox\Common\HashFunctions;

class FilesManager
{
    private static ?self $instance = null;

    public static function singleton(): self
    {
        if(self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }
    public function addFile(string $compressedData, string $contentType = null): string
    {
        (string)$hash = HashFunctions::computeHashString($compressedData);
        $this->upload($compressedData, $contentType);
        return $hash;
    }
    public function upload(string $sourceContentHash, string $data, ?string $contentType = null, ?string $format = null): void
    {
        $hash = $format ? md5("{$sourceContentHash}_{$format}") : $sourceContentHash;

        $s3Path = $format ? "{$format}/{$hash}" : $hash;

        try {
            if (!Storage::disk('s3')->exists($s3Path)) {
                Storage::disk('s3')->put($s3Path, $data, [
                    'ContentType' => $contentType ?: 'application/octet-stream',
                ]);

                event(new \GooberBlox\Events\FileUploaded([
                    'hash' => $hash,
                    'file_name' => $s3Path,
                    'file_size' => strlen($data),
                    'destination' => 'S3',
                    'content_type' => $contentType,
                ]));

                return;
            }
        } catch (\Exception $e) {
            Log::warning("S3 upload failed for {$hash}, using local storage: {$e->getMessage()}");
        }

        $localPath = $this->getLocalPath($hash);
        Storage::disk('local')->put($localPath, $data);

        event(new \GooberBlox\Events\FileUploaded([
            'hash' => $hash,
            'file_name' => $localPath,
            'file_size' => strlen($data),
            'destination' => 'Local',
            'content_type' => $contentType,
        ]));
    }

    private function getLocalPath(string $hash): string
    {
        $folder = substr($hash, 0, 2);
        return "file_store/{$folder}/{$hash}";
    }
}
