<?php

declare(strict_types=1);

namespace App\Tests\Feature\Book\Application\UseCase\Command;

use App\Book\Application\UseCase\Command\Create\CreateBookCommand;
use App\Book\Application\UseCase\Command\Create\CreateBookCommandHandler;
use App\Book\Domain\Repository\BookRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * @internal
 *
 * @coversNothing
 */
class CreateBookCommandHandlerTest extends KernelTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        self::bootKernel();
    }

    public function testCreateBook(): void
    {
        $createBookCommand = new CreateBookCommand(
            $uuid = '123e4567-e89b-12d3-a456-426614174000',
            'Clean Code',
            'A Handbook of Agile Software Craftsmanship',
            'Robert',
            'Martin',
        );

        /** @var BookRepositoryInterface $repository */
        $repository = self::getContainer()->get(BookRepositoryInterface::class);
        $handler = new CreateBookCommandHandler($repository);
        $handler($createBookCommand);

        /** @var EntityManagerInterface $entityManager */
        $entityManager = self::getContainer()->get(EntityManagerInterface::class);
        self::assertTrue($entityManager->getConnection()->createQueryBuilder()
            ->select('COUNT(*)')
            ->from('book')
            ->where('uuid = :uuid')
            ->setParameter('uuid', $uuid)
            ->executeQuery()
            ->fetchOne());
    }
}
