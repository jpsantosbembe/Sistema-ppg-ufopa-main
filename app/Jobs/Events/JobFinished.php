<?php

namespace App\Jobs\Events;

class JobFinished
{
    public $progress;

    public function __construct($progress)
    {
        $this->progress = $progress;
    }
}
