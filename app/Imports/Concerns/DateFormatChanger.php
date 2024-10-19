<?php

namespace App\Imports\Concerns;

use Carbon\Carbon;
use DateTime;

trait DateFormatChanger
{
    private function changeDateFormat($value)
    {
        if (empty($value)) $value = null;

        if (is_string($value) and preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $value)) {
            $datetime = DateTime::createFromFormat('d/m/Y', $value);
            $value = $datetime->format('Y-m-d');
        }

        return $value;
    }
    private function changeDateTimeFormat($value)
    {
        if (empty($value)) $value = null;
        return Carbon::createFromFormat( 'd/m/Y - H:i', $value)->format('Y-m-d H:i:s');
    }

}
