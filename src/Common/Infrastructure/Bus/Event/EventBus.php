<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\Bus\Event;

use App\Common\Application\Bus\Event\EventBusInterface;
use App\Common\Domain\Event\EventInterface;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;

final readonly class EventBus implements EventBusInterface
{
    public function __construct(
        private MessageBusInterface $messageBus,
    ) {}

    /**
     * @throws \Throwable
     */
    #[\Override]
    public function dispatch(EventInterface $event): void
    {
        try {
            $this->messageBus->dispatch($event);
        } catch (HandlerFailedException $handlerFailedException) {
            while ($handlerFailedException instanceof HandlerFailedException) {
                /** @var \Throwable $handlerFailedException */
                $handlerFailedException = $handlerFailedException->getPrevious();
            }

            throw $handlerFailedException;
        }
    }
}
