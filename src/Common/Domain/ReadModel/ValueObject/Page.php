<?php

declare(strict_types=1);

namespace App\Common\Domain\ReadModel\ValueObject;

final readonly class Page
{
    public const int DEFAULT_PAGE = 1;

    private int $value;

    public function __construct(int $page = self::DEFAULT_PAGE)
    {
        if ($page < 1) {
            $page = self::DEFAULT_PAGE;
        }

        $this->value = $page;
    }

    public function value(): int
    {
        return $this->value;
    }
}
