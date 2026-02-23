<?php

namespace GooberBlox\Web\Code\CookieConstraint;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Carbon\Carbon;

class CookieConstraintValidator {
    private static function activeButtonTextCsv(): array
    {
        return array_map('strtolower', explode(',', config('gooberblox.web-code.Default.CookieConstraint_AllowedButtonValuesCSV')));
    }

    public static function hasConstrainedCookie(Request $request) : bool
    {
        return $request->cookies->has(config('gooberblox.web-code.Default.CookieConstraintCookieName'));
    }

    public static function setConstrainedCookie(Response $response, string $host, string $domainSuffix = ''): Response
    {
        $constrainedCookie = config('gooberblox.web-code.Default.CookieConstraintCookieName');
        $cookieTimeSpan = config('gooberblox.web-code.Default.CookieConstraintExpiration'); 

        list($days, $time) = explode('.', $cookieTimeSpan);
        list($hours, $minutes, $seconds) = explode(':', $time);

        $expiresAt = Carbon::now()
            ->addDays((int)$days)
            ->addHours((int)$hours)
            ->addMinutes((int)$minutes)
            ->addSeconds((int)$seconds);

        $domain = '';
        if ($domainSuffix !== '' && Str::endsWith($host, $domainSuffix)) {
            $domain = $domainSuffix;
        }

        return $response->withCookie(
            cookie($constrainedCookie, null, now()->diffInMinutes($expiresAt), '/', $domain, true, true)
        );
    }
}