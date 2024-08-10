<?php

declare(strict_types=1);

namespace App\Tests\Unit\Common\Infrastructure\Bus\Event;

use App\Common\Domain\Event\EventInterface;
use App\Common\Infrastructure\Bus\Event\EventBus;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * @internal
 *
 * @coversNothing
 */
class EventBusTest extends TestCase
{
    public function testDispatchCallsMessageBusWithEvent(): void
    {
        $messageBusMock = $this->createMock(MessageBusInterface::class);
        $eventMock = $this->createMock(EventInterface::class);

        $messageBusMock->expects(self::once())
            ->method('dispatch')
            ->with($eventMock)
        ;

        $EventBus = new EventBus($messageBusMock);
        $EventBus->dispatch($eventMock);
    }

    public function testDispatchHandlesHandlerFailedException(): void
    {
        $this->expectException(\Throwable::class);

        $messageBusMock = $this->createMock(MessageBusInterface::class);
        $eventMock = $this->createMock(EventInterface::class);

        $messageBusMock->method('dispatch')
            ->willThrowException(
                new HandlerFailedException(new Envelope($eventMock), [new \Exception()]),
            )
        ;

        $eventBus = new EventBus($messageBusMock);
        $eventBus->dispatch($eventMock);
    }
}
