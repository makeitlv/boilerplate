<?php

declare(strict_types=1);

namespace App\Tests\Feature\Book\Application\UseCase\Command;

use App\Book\Application\UseCase\Command\Create\CreateBookCommand;
use App\Book\Application\UseCase\Command\Delete\DeleteBookCommand;
use App\Common\Application\Bus\Command\CommandBusInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * @internal
 *
 * @coversNothing
 */
class DeleteBookCommandHandlerTest extends KernelTestCase
{
    public function testDeleteBook(): void
    {
        $createBookCommand = new CreateBookCommand(
            $uuid = '123e4567-e89b-12d3-a456-426614174001',
            'Clean Code',
            'A Handbook of Agile Software Craftsmanship',
            'Robert',
            'Martin',
        );

        /** @var CommandBusInterface $commandBus */
        $commandBus = self::getContainer()->get(CommandBusInterface::class);
        $commandBus->dispatch($createBookCommand);

        /** @var EntityManagerInterface $entityManager */
        $entityManager = self::getContainer()->get(EntityManagerInterface::class);

        /** @var array<string, string> $book */
        $book = $entityManager
            ->getConnection()
            ->createQueryBuilder()
            ->select('*')
            ->from('books')
            ->where('uuid = :uuid')
            ->setParameter('uuid', $uuid)
            ->executeQuery()
            ->fetchAssociative()
        ;

        self::assertNotEmpty($book);

        $deleteBookCommand = new DeleteBookCommand($uuid);
        $commandBus->dispatch($deleteBookCommand);

        $book = $entityManager
            ->getConnection()
            ->createQueryBuilder()
            ->select('*')
            ->from('books')
            ->where('uuid = :uuid')
            ->setParameter('uuid', $uuid)
            ->executeQuery()
            ->fetchAssociative()
        ;

        self::assertFalse($book);
    }
}
