<?php

namespace GooberBlox\Data;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

use GooberBlox\Data\Enums\FormatVersion;
use GooberBlox\Data\Exceptions\{KeyNotFoundException, InvalidKeyException, SignatureCreationFailedException};
class SecurityNotary extends Controller
{
    public static function createResourceSignature($resource) : string
    {
        return self::createSignature(json_encode($resource, JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
    }
    public static function createSignature(string $message) : string
    {
        $privateKeyContents = Storage::get('keys/PrivateKey.pem');

        if (!$privateKeyContents) {
            throw new KeyNotFoundException("Private key not found.");
        }

        $privateKey = openssl_pkey_get_private($privateKeyContents);
        if (!$privateKey) {
            throw new InvalidKeyException("Private key is invalid.");
        }
        
        $signature = null;
        $success = openssl_sign($message, $signature, $privateKey, OPENSSL_ALGO_SHA1);

        if (!$success) {
            throw new SignatureCreationFailedException();
        }

        return base64_encode($signature);
    }
    
    public static function verifySignature(string $rawTicket, string $base64Signature) : string
    {
        $publicKeyContents = Storage::get('keys/PublicKey.pem');

        if (!$publicKeyContents) {
            throw new KeyNotFoundException("Public key not found.");
        }

        $publicKey = openssl_pkey_get_public($publicKeyContents);
        if (!$publicKey) {
            throw new InvalidKeyException("Public key is invalid.");
        }

        $signature = base64_decode($base64Signature, true);

        if ($signature === false) {
            return false;
        }

        return openssl_verify(
            $rawTicket,
            $signature,
            $publicKey,
            OPENSSL_ALGO_SHA1
        ) === 1;
    }
    public static function signScript(string $script, FormatVersion $version = FormatVersion::V2) : string
    {
        $signature = null;
        switch($version)
        {
            case FormatVersion::V2:
                $script = "\r\n" . $script;
                $signature = self::CreateSignature($script);
                return "--rbxsig%{$signature}%{$script}";
            case FormatVersion::V1:
                break;
        }

        $signature = self::createSignature($script);
		return "%{$signature}%{$script}";
    }
}