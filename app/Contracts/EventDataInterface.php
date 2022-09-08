<?php

declare(strict_types=1);

namespace App\Contracts;

/**
 * @property int $id
 */
interface EventDataInterface
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(): array;
}
