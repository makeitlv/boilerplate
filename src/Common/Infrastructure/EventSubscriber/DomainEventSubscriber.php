<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\EventSubscriber;

use App\Common\Application\Bus\Event\EventBusInterface;
use App\Common\Domain\Aggregate\AggregateRoot;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\PostFlushEventArgs;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;

final class DomainEventSubscriber implements EventSubscriber
{
    /**
     * @var array<AggregateRoot>
     */
    private array $aggregates = [];

    public function __construct(
        private readonly EventBusInterface $eventBus,
    ) {}

    #[\Override]
    /**
     * @return array<string>
     */
    public function getSubscribedEvents(): array
    {
        return [
            Events::postFlush,
            Events::postPersist,
            Events::postUpdate,
            Events::postRemove,
        ];
    }

    public function postFlush(PostFlushEventArgs $postFlushEventArgs): void
    {
        foreach ($this->aggregates as $aggregate) {
            foreach ($aggregate->pullEvents() as $event) {
                $this->eventBus->dispatch($event);
            }
        }
    }

    /**
     * @param LifecycleEventArgs<EntityManagerInterface> $lifecycleEventArgs
     */
    public function postPersist(LifecycleEventArgs $lifecycleEventArgs): void
    {
        $this->keepAggregateRoots($lifecycleEventArgs);
    }

    /**
     * @param LifecycleEventArgs<EntityManagerInterface> $lifecycleEventArgs
     */
    public function postUpdate(LifecycleEventArgs $lifecycleEventArgs): void
    {
        $this->keepAggregateRoots($lifecycleEventArgs);
    }

    /**
     * @param LifecycleEventArgs<EntityManagerInterface> $lifecycleEventArgs
     */
    public function postRemove(LifecycleEventArgs $lifecycleEventArgs): void
    {
        $this->keepAggregateRoots($lifecycleEventArgs);
    }

    /**
     * @param LifecycleEventArgs<EntityManagerInterface> $lifecycleEventArgs
     */
    private function keepAggregateRoots(LifecycleEventArgs $lifecycleEventArgs): void
    {
        $object = $lifecycleEventArgs->getObject();

        if (!$object instanceof AggregateRoot) {
            return;
        }

        $this->aggregates[] = $object;
    }
}
