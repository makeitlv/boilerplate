<?php

declare(strict_types=1);

namespace App\Tests\Unit\Common\Infrastructure\EventSubscriber;

use App\Common\Application\Bus\Event\EventBusInterface;
use App\Common\Domain\Aggregate\AggregateRoot;
use App\Common\Domain\Event\EventInterface;
use App\Common\Infrastructure\EventSubscriber\DomainEventSubscriber;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\PostFlushEventArgs;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
class DomainEventSubscriberTest extends TestCase
{
    public function testPostPersist(): void
    {
        $eventBusMock = $this->createMock(EventBusInterface::class);
        $entityManagerMock = $this->createMock(EntityManagerInterface::class);
        $aggregateRootMock = $this->createMock(AggregateRoot::class);
        $lifecycleEventArgs = new LifecycleEventArgs($aggregateRootMock, $entityManagerMock);

        $domainEventSubscriber = new DomainEventSubscriber($eventBusMock);
        $domainEventSubscriber->postPersist($lifecycleEventArgs);

        self::assertContains($aggregateRootMock, $this->getPrivateProperty($domainEventSubscriber, 'aggregates'));
    }

    public function testPostUpdate(): void
    {
        $eventBusMock = $this->createMock(EventBusInterface::class);
        $entityManagerMock = $this->createMock(EntityManagerInterface::class);
        $aggregateRootMock = $this->createMock(AggregateRoot::class);
        $lifecycleEventArgs = new LifecycleEventArgs($aggregateRootMock, $entityManagerMock);

        $domainEventSubscriber = new DomainEventSubscriber($eventBusMock);
        $domainEventSubscriber->postUpdate($lifecycleEventArgs);

        self::assertContains($aggregateRootMock, $this->getPrivateProperty($domainEventSubscriber, 'aggregates'));
    }

    public function testPostRemove(): void
    {
        $eventBusMock = $this->createMock(EventBusInterface::class);
        $entityManagerMock = $this->createMock(EntityManagerInterface::class);
        $aggregateRootMock = $this->createMock(AggregateRoot::class);
        $lifecycleEventArgs = new LifecycleEventArgs($aggregateRootMock, $entityManagerMock);

        $domainEventSubscriber = new DomainEventSubscriber($eventBusMock);
        $domainEventSubscriber->postRemove($lifecycleEventArgs);

        self::assertContains($aggregateRootMock, $this->getPrivateProperty($domainEventSubscriber, 'aggregates'));
    }

    public function testPostFlush(): void
    {
        $eventBusMock = $this->createMock(EventBusInterface::class);
        $postFlushEventArgs = $this->createMock(PostFlushEventArgs::class);
        $aggregateRootMock = $this->createMock(AggregateRoot::class);

        $domainEventSubscriber = new DomainEventSubscriber($eventBusMock);
        $this->setPrivateProperty($domainEventSubscriber, 'aggregates', [$aggregateRootMock]);

        $aggregateRootMock->expects(self::once())
            ->method('pullEvents')
            ->willReturn([$this->createMock(EventInterface::class)])
        ;

        $eventBusMock->expects(self::once())
            ->method('dispatch')
        ;

        $domainEventSubscriber->postFlush($postFlushEventArgs);
    }

    /**
     * @return array<AggregateRoot>
     */
    private function getPrivateProperty(object $object, string $property): array
    {
        $reflectionClass = new \ReflectionClass($object);
        $property = $reflectionClass->getProperty($property);

        /** @var array<AggregateRoot> */
        return $property->getValue($object);
    }

    /**
     * @param array<AggregateRoot> $value
     */
    private function setPrivateProperty(object $object, string $property, array $value): void
    {
        $reflectionClass = new \ReflectionClass($object);
        $property = $reflectionClass->getProperty($property);
        $property->setValue($object, $value);
    }
}
