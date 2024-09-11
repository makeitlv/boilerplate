<?php

declare(strict_types=1);

namespace App\Book\Infrastructure\Query;

use App\Book\Domain\Query\BookQueryInterface;
use App\Book\Domain\ReadModel\BookRead;
use App\Common\Domain\ReadModel\PaginationData;
use App\Common\Infrastructure\Query\DBAL\AbstractDBALQuery;

final readonly class DBALBookQuery extends AbstractDBALQuery implements BookQueryInterface
{
    /**
     * @return PaginationData<BookRead>
     */
    #[\Override]
    public function fetchBooks(int $page, int $limit): PaginationData
    {
        $totalPages = $this->getTotalPages($this->getTotalRecords(), $limit);
        $page = $this->getPage($page, $totalPages);

        /** @var array<array-key, array<string, string>> $books */
        $books = $this->queryBuilder->select('*')
            ->from('books')
            ->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit)
            ->executeQuery()
            ->fetchAllAssociative()
        ;

        return new PaginationData(
            \array_map(static fn (array $book): BookRead => new BookRead(
                $book['title'],
                \sprintf('%s - %s', $book['firstname'], $book['lastname']),
                $book['description'],
            ), $books),
            $page,
            $totalPages,
        );
    }

    private function getTotalRecords(): int
    {
        $totalRecords = $this->queryBuilder->select('COUNT(*)')
            ->from('books')
            ->executeQuery()
            ->fetchOne()
        ;

        return \is_numeric($totalRecords) ? (int) $totalRecords : 0;
    }

    private function getTotalPages(int $totalRecords, int $limit): int
    {
        return (int) ceil($totalRecords / $limit);
    }

    private function getPage(int $page, int $totalPages): int
    {
        return min($page, $totalPages);
    }
}
