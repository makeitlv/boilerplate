<?php

declare(strict_types=1);

namespace App\Tests\Browser;

use App\Book\Application\UseCase\Command\Create\CreateBookCommand;
use App\Common\Application\Bus\Command\CommandBusInterface;
use Faker\Factory;
use Symfony\Component\Panther\PantherTestCase;

/**
 * @internal
 *
 * @coversNothing
 */
class ListBookActionTest extends PantherTestCase
{
    #[\Override]
    public static function setUpBeforeClass(): void
    {
        StaticDriver::setKeepStaticConnections(false);
    }

    #[\Override]
    public static function tearDownAfterClass(): void
    {
        StaticDriver::setKeepStaticConnections(true);
    }

    public function testBooksExists(): void
    {
        $client = static::createPantherClient();

        $generator = Factory::create();

        /** @var CommandBusInterface $commandBus */
        $commandBus = self::getContainer()->get(CommandBusInterface::class);

        $totalBooks = 10;
        foreach (range(1, $totalBooks) as $index) {
            $commandBus->dispatch(
                new CreateBookCommand(
                    $generator->uuid(),
                    $generator->sentence(),
                    $generator->sentence(),
                    $generator->firstName(),
                    $generator->lastName(),
                ),
            );
        }

        $crawler = $client->request('GET', '/');

        $books = $crawler->filter('#books > *');

        self::assertEquals($totalBooks, $books->count());
    }
}
