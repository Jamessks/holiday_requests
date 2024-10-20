<?php

namespace Core;

use DateTime;

class Validator
{
    public static function string($value, $min = 1, $max = INF)
    {
        $value = trim($value);

        return strlen($value) >= $min && strlen($value) <= $max;
    }

    public static function email($value)
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }

    public static function date($value, $format = 'Y-m-d')
    {
        $dateTime = DateTime::createFromFormat($format, $value);

        return $dateTime && $dateTime->format($format) === $value;
    }

    public static function integer($value)
    {
        return is_numeric($value) && (int)$value == $value;
    }
}
