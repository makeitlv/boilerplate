<?php

declare(strict_types=1);

namespace App\Common\Application\Bus\Event;

use App\Common\Domain\Event\EventInterface;

interface EventBusInterface
{
    public function dispatch(EventInterface $event): void;
}
