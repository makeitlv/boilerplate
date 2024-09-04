<?php

declare(strict_types=1);

namespace App\Book\Domain\Query;

use App\Book\Domain\ReadModel\BookRead;

interface BookQueryInterface
{
    /**
     * @return array<BookRead>
     */
    public function fetchBooks(int $page, int $limit): array;
}
