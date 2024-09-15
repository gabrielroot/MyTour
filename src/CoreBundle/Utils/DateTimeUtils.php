<?php

namespace MyTour\CoreBundle\Utils;

use DateTime;

class DateTimeUtils
{

    /**
     * @param mixed $dateTime
     * @return DateTime|null
     */
    public static function getDateTimeFromMixed(mixed $dateTime): ?DateTime
    {
        if ($dateTime instanceof DateTime) {
            return $dateTime;
        }

        if (is_string($dateTime)) {
            return DateTime::createFromFormat((strlen($dateTime) === 10) ? 'd/m/Y' : 'd/m/Y H:i', $dateTime);
        }

        return null;
    }

    /**
     * @param DateTime|null $dateTime
     * @param bool $justDate
     * @return string|null
     */
    public static function getFormatedDateTime(?Datetime $dateTime, bool $justDate = false): ?string
    {
        return $dateTime?->format('Y-m-d' . ($justDate ? '' : ' H:i:s'));
    }
}