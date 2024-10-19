<?php

namespace App\Imports\Concerns;

use DateTime;

trait IntboolChanger
{
    public function changeToIntbool($value):int
    {
        $true_values = [
          'sim', 'verdadeiro', 'true', 's', 'v', 't', '1'
        ];

        if (is_string($value)) {
            $value = in_array(trim(strtolower($value)), $true_values);
        }

        return $value?1:0;
    }

}
