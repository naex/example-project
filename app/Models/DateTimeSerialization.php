<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use DateTimeInterface;

trait DateTimeSerialization
{
    protected function serializeDate(DateTimeInterface $date): ?string
    {
        $carbonInstance = Carbon::instance($date);

        return $carbonInstance->toIso8601String();
    }
}
