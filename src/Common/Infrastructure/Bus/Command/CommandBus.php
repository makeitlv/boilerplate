<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\Bus\Command;

use App\Common\Application\Bus\Command\CommandBus as Bus;
use App\Common\Application\Bus\Command\CommandInterfaceInterface;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;

final readonly class CommandBus implements Bus
{
    public function __construct(
        private MessageBusInterface $messageBus,
    ) {}

    /**
     * @throws \Throwable
     */
    #[\Override]
    public function dispatch(CommandInterfaceInterface $commandInterface): void
    {
        try {
            $this->messageBus->dispatch($commandInterface);
        } catch (HandlerFailedException $handlerFailedException) {
            while ($handlerFailedException instanceof HandlerFailedException) {
                /** @var \Throwable $handlerFailedException */
                $handlerFailedException = $handlerFailedException->getPrevious();
            }

            throw $handlerFailedException;
        }
    }
}
