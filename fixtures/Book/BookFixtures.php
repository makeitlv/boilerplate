<?php

declare(strict_types=1);

namespace DataFixtures\Book;

use App\Book\Application\UseCase\Command\Create\CreateBookCommand;
use App\Common\Application\Bus\Command\CommandBusInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

final class BookFixtures extends Fixture
{
    public function __construct(private readonly CommandBusInterface $commandBus) {}

    #[\Override]
    public function load(ObjectManager $objectManager): void
    {
        $generator = Factory::create();

        for ($i = 0; $i < 100; ++$i) {
            $this->commandBus->dispatch(
                new CreateBookCommand(
                    $generator->uuid(),
                    $generator->sentence(),
                    $generator->sentence(),
                    $generator->firstName(),
                    $generator->lastName(),
                ),
            );
        }
    }
}
