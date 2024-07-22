<?php

declare(strict_types=1);

namespace App\Tests\Unit\Common\Infrastructure\Bus\Query;

use App\Common\Application\Bus\Query\QueryInterface;
use App\Common\Infrastructure\Bus\Query\QueryBusInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

/**
 * @internal
 *
 * @coversNothing
 */
class QueryBusTest extends TestCase
{
    public function testAskDispatchesQueryAndReturnsResult(): void
    {
        $messageBusMock = $this->createMock(MessageBusInterface::class);
        $queryMock = $this->createMock(QueryInterface::class);
        $expectedResult = 'result';

        $messageBusMock->expects(self::once())
            ->method('dispatch')
            ->with($queryMock)
            ->willReturn(
                new Envelope($queryMock, [new HandledStamp($expectedResult, 'handler')]),
            )
        ;

        $queryBus = new QueryBusInterface($messageBusMock);
        $result = $queryBus->ask($queryMock);

        self::assertEquals($expectedResult, $result);
    }

    public function testAskHandlesHandlerFailedException(): void
    {
        $this->expectException(\Throwable::class);

        $messageBusMock = $this->createMock(MessageBusInterface::class);
        $queryMock = $this->createMock(QueryInterface::class);

        $messageBusMock->method('dispatch')
            ->willThrowException(
                new HandlerFailedException(new Envelope($queryMock), [new \Exception()]),
            )
        ;

        $queryBus = new QueryBusInterface($messageBusMock);
        $queryBus->ask($queryMock);
    }
}
