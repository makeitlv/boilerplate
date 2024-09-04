<?php

declare(strict_types=1);

namespace App\Common\Domain\ReadModel\ValueObject;

final readonly class Limit
{
    public const int MAX_LIMIT = 100;

    public const int DEFAULT_LIMIT = 30;

    private int $value;

    public function __construct(int $limit = self::DEFAULT_LIMIT)
    {
        if ($limit < 1) {
            $limit = 30;
        }

        if ($limit > self::MAX_LIMIT) {
            $limit = self::MAX_LIMIT;
        }

        $this->value = $limit;
    }

    public function value(): int
    {
        return $this->value;
    }
}
