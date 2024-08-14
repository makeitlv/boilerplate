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

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 100; ++$i) {
            $this->commandBus->dispatch(
                new CreateBookCommand(
                    $faker->uuid,
                    $faker->sentence,
                    $faker->sentence,
                    $faker->firstName,
                    $faker->lastName,
                ),
            );
        }
    }
}
