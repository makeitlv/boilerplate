<?php

declare(strict_types=1);

namespace App\Tests\Unit\Common\Infrastructure\Bus\Command;

use App\Common\Application\Bus\Command\CommandInterfaceInterface;
use App\Common\Infrastructure\Bus\Command\CommandBus;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * @internal
 *
 * @coversNothing
 */
class CommandBusTest extends TestCase
{
    public function testDispatchCallsMessageBusWithCommand(): void
    {
        $messageBusMock = $this->createMock(MessageBusInterface::class);
        $commandMock = $this->createMock(CommandInterfaceInterface::class);

        $messageBusMock->expects(self::once())
            ->method('dispatch')
            ->with($commandMock)
        ;

        $commandBus = new CommandBus($messageBusMock);
        $commandBus->dispatch($commandMock);
    }

    public function testDispatchHandlesHandlerFailedException(): void
    {
        $this->expectException(\Throwable::class);

        $messageBusMock = $this->createMock(MessageBusInterface::class);
        $commandMock = $this->createMock(CommandInterfaceInterface::class);

        $messageBusMock->method('dispatch')
            ->willThrowException(
                new HandlerFailedException(new Envelope($commandMock), [new \Exception()]),
            )
        ;

        $commandBus = new CommandBus($messageBusMock);
        $commandBus->dispatch($commandMock);
    }
}
