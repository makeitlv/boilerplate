<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\Bus\Query;

use App\Common\Application\Bus\Query\QueryBusInterface as Bus;
use App\Common\Application\Bus\Query\QueryInterface;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

final readonly class QueryBusInterface implements Bus
{
    public function __construct(
        private MessageBusInterface $messageBus,
    ) {}

    /**
     * @throws \Throwable
     */
    #[\Override]
    public function ask(QueryInterface $query): mixed
    {
        try {
            $envelope = $this->messageBus->dispatch($query);

            /** @var HandledStamp $stamp */
            $stamp = $envelope->last(HandledStamp::class);

            return $stamp->getResult();
        } catch (HandlerFailedException $handlerFailedException) {
            while ($handlerFailedException instanceof HandlerFailedException) {
                /** @var \Throwable $handlerFailedException */
                $handlerFailedException = $handlerFailedException->getPrevious();
            }

            throw $handlerFailedException;
        }
    }
}
