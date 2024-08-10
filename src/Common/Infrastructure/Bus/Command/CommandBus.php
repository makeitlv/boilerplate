<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\Bus\Command;

use App\Common\Application\Bus\Command\CommandBusInterface;
use App\Common\Application\Bus\Command\CommandInterface;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;

final readonly class CommandBus implements CommandBusInterface
{
    public function __construct(
        private MessageBusInterface $messageBus,
    ) {}

    /**
     * @throws \Throwable
     */
    #[\Override]
    public function dispatch(CommandInterface $command): void
    {
        try {
            $this->messageBus->dispatch($command);
        } catch (HandlerFailedException $handlerFailedException) {
            while ($handlerFailedException instanceof HandlerFailedException) {
                /** @var \Throwable $handlerFailedException */
                $handlerFailedException = $handlerFailedException->getPrevious();
            }

            throw $handlerFailedException;
        }
    }
}
