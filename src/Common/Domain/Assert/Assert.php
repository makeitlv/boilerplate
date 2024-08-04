<?php

declare(strict_types=1);

namespace App\Common\Domain\Assert;

final class Assert extends \Webmozart\Assert\Assert
{
    protected static function reportInvalidArgument($message): void
    {
        throw new InvalidArgumentException($message);
    }
}
