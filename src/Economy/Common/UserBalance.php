<?php

namespace GooberBlox\Economy\Common;

use GooberBlox\Economy\Common\Models\{RobuxBalance, TicketsBalance};
class UserBalance {
    public static function getRobuxBalance(int $userId): int
    {
        return RobuxBalance::getOrCreate($userId)->value;
    }

    public static function getTicketsBalance(int $userId): int
    {
        return TicketsBalance::getOrCreate($userId)->value;
    }

	public static function creditRobux(int $userId, int $amount): int
	{
        $balance = RobuxBalance::getOrCreate($userId);
        $balance->credit($amount);

        return $balance->value;
	}

	public static function tryDebitRobux(int $userId, int $amount): bool
	{
        return RobuxBalance::getOrCreate($userId)->tryDebit($amount);
	}

    public static function creditTickets(int $userId, int $amount): int
	{
        $balance = TicketsBalance::getOrCreate($userId);
        $balance->credit($amount);

        return $balance->value;
	}

	public static function tryDebitTickets(int $userId, int $amount): bool
	{
        return TicketsBalance::getOrCreate($userId)->tryDebit($amount);
	}
}