<?php

namespace App\Helpers;

class DateHelper
{
    public static function translateDay(string $englishDay): string
    {
        $translations = [
            'Monday' => 'Lundi',
            'Tuesday' => 'Mardi',
            'Wednesday' => 'Mercredi',
            'Thursday' => 'Jeudi',
            'Friday' => 'Vendredi',
            'Saturday' => 'Samedi',
            'Sunday' => 'Dimanche',
        ];

        return $translations[$englishDay] ?? $englishDay;
    }
}
