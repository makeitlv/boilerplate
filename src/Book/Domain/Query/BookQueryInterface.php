<?php

declare(strict_types=1);

namespace App\Book\Domain\Query;

use App\Book\Domain\ReadModel\BookRead;
use App\Common\Domain\ReadModel\PaginationData;

interface BookQueryInterface
{
    /**
     * @return PaginationData<BookRead>
     */
    public function fetchBooks(int $page, int $limit): PaginationData;
}
