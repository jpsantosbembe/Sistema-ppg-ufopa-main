<?php

namespace App\Imports\Concerns;

trait HasAttributeAdapter
{
    use DateFormatChanger;
    use IntboolChanger;

    public function setAttribute($key, $value)
    {
        return parent::setAttribute($key, $this->valueCast($key, $value));
    }

    private function valueCast($key, $value)
    {
        if (is_array($this->adapters) and array_key_exists($key, $this->adapters)) {
            switch ($this->adapters[$key]) {
                case "dateformat":
                    $value = $this->changeDateFormat($value);
                    break;
                case "intbool":
                    $value = $this->changeToIntbool($value);
                    break;
                case "datetime_format":
                    $value = $this->changeDateTimeFormat($value);
            }
        }
        return $value;
    }

}
