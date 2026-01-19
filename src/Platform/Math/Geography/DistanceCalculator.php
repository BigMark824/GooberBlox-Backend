<?php

namespace GooberBlox\Platform\Math\Geography;

class DistanceCalculator
{
    /*
        Measures distance in miles between two points, for matchmaking
    */
    public static function calculateDistance(float $lat1, float $lon1, float $lat2, float $lon2)
    {
        (float) $rlat1 = pi() * $lat1 / 180.0;
        (float) $rlat2 = pi() * $lat2 / 180.0;
        (float) $theta = $lon1 - $lon2;
        (float) $rtheta = pi() * $theta / 180.0;	
        return acos(sin($rlat1) * sin($rlat2) + cos($rlat1) * cos($rlat2) * cos($rtheta)) * 180.0 / pi() * 60.0 * 1.1515;
    }
}