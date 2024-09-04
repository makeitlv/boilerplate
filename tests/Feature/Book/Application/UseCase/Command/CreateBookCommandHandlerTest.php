<?php

declare(strict_types=1);

namespace App\Tests\Feature\Book\Application\UseCase\Command;

use App\Book\Application\UseCase\Command\Create\CreateBookCommand;
use App\Common\Application\Bus\Command\CommandBusInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * @internal
 *
 * @coversNothing
 */
class CreateBookCommandHandlerTest extends KernelTestCase
{
    public function testCreateBook(): void
    {
        $createBookCommand = new CreateBookCommand(
            $uuid = '123e4567-e89b-12d3-a456-426614174000',
            $title = 'Clean Code',
            $description = 'A Handbook of Agile Software Craftsmanship',
            $firstname = 'Robert',
            $lastname = 'Martin',
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

        self::assertEquals($uuid, $book['uuid']);
        self::assertEquals($title, $book['title']);
        self::assertEquals($description, $book['description']);
        self::assertEquals($firstname, $book['firstname']);
        self::assertEquals($lastname, $book['lastname']);
    }
}
