<?php

declare(strict_types=1);

namespace App\Book\Infrastructure\Repository;

use App\Book\Domain\Model\Book;
use App\Book\Domain\Repository\BookRepositoryInterface;
use App\Common\Domain\Model\ValueObject\Uuid;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @template-extends ServiceEntityRepository<Book>
 */
final class DoctrineBookRepository extends ServiceEntityRepository implements BookRepositoryInterface
{
    public function __construct(ManagerRegistry $managerRegistry)
    {
        parent::__construct($managerRegistry, Book::class);
    }

    #[\Override]
    public function persist(Book $book): void
    {
        $this->getEntityManager()->persist($book);
    }

    #[\Override]
    public function removeByUuid(Uuid $uuid): void
    {
        $book = $this->find((string) $uuid);

        if ($book === null) {
            throw new \RuntimeException('Book not found.');
        }

        $this->getEntityManager()->remove($book);
    }
}
