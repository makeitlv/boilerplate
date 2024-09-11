<?php

declare(strict_types=1);

namespace App\Tests\Feature\Book\Application\UseCase\Query;

use App\Book\Application\UseCase\Command\Create\CreateBookCommand;
use App\Book\Application\UseCase\Query\List\ListBookQuery;
use App\Book\Domain\ReadModel\BookRead;
use App\Common\Application\Bus\Command\CommandBusInterface;
use App\Common\Application\Bus\Query\QueryBusInterface;
use App\Common\Domain\ReadModel\PaginationData;
use Faker\Factory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * @internal
 *
 * @coversNothing
 */
class ListBookQueryHandlerTest extends KernelTestCase
{
    public function testListBooks(): void
    {
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

        /** @var QueryBusInterface $queryBus */
        $queryBus = self::getContainer()->get(QueryBusInterface::class);

        /** @var PaginationData<BookRead> $paginationData */
        $paginationData = $queryBus->ask(new ListBookQuery());
        $books = $paginationData->items;

        self::assertCount($totalBooks, $books);
        self::assertEquals(1, $paginationData->currentPage);
        self::assertEquals(1, $paginationData->totalPages);
    }
}
