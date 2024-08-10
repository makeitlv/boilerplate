<?php

declare(strict_types=1);

namespace App\Common\Domain\Aggregate;

use App\Common\Domain\Event\EventInterface;

abstract class AggregateRoot
{
    /**
     * @var array<EventInterface>
     */
    private array $events = [];

    /**
     * @return array<EventInterface>
     */
    public function pullEvents(): array
    {
        $events = $this->events;
        $this->events = [];

        return $events;
    }

    protected function recordEvent(EventInterface $event): void
    {
        $this->events[] = $event;
    }
}
