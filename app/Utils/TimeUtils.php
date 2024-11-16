<?php

namespace App\Utils;

class TimeUtils
{
    public static function secondsToMinutes(int $seconds): int
    {
        return intdiv($seconds, 60);
    }

    public static function formatDuration(int $totalMinutes): string
    {
        $hours = floor($totalMinutes / 60); 
        $minutes = $totalMinutes % 60; 
        $result = '';

        if ($hours > 0) {
            $result .= $hours . ' hora' . ($hours > 1 ? 's' : '') . ' ';
        }

        if ($minutes > 0) {
            $result .= $minutes . ' minuto' . ($minutes > 1 ? 's' : '');
        }

        return $result;
    }
}
