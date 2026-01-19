<?php

namespace GooberBlox\Security;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use GooberBlox\Security\Exceptions\InvalidApiKeyException;
use GooberBlox\Security\Models\{AllowedMD5Hashes, AllowedSecurityVersions};
class ClientValidation
{
    public static function getAllowedMd5Hashes(?string $apiKey): array|null
    {
        if (empty($apiKey) || env('GRID_API_KEY') !== $apiKey) {
            throw new InvalidApiKeyException();
        }

        $allowedMd5Hashes = AllowedMD5Hashes::pluck('md5_hash')->toArray();

        return $allowedMd5Hashes ?: null;
    }

    public static function getAllowedSecurityVersions(?string $apiKey): array|null
    {
        if (empty($apiKey) || env('GRID_API_KEY') !== $apiKey) {
            throw new InvalidApiKeyException();
        }

        $allowedSecurityVersions = AllowedSecurityVersions::pluck('version')->toArray();

        return $allowedSecurityVersions ?: null;
    }

    public static function genClientTicket(int $userId, string $userName, string $jobId, string $charApp) : string
    {
        $time = Carbon::now()->timestamp;
        $ticket1 = "$userId\n$userName\n$charApp\n$jobId\n$time";
        $ticket2 = "$userId\n$jobId\n$time";

        $privateKey = Storage::get('keys/PrivateKey.pem');
        if (!openssl_sign($ticket1, $signature1, $privateKey))
            return "$time;0;0";
        if (!openssl_sign($ticket2, $signature2, $privateKey))
            return "$time;0;0";
        
        $b64_signature1 = base64_encode($signature1);
        $b64_signature2 = base64_encode($signature2);
        return "$time;$b64_signature1;$b64_signature2";
    }
}
