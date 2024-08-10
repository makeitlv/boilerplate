<?php

declare(strict_types=1);

namespace App\Book\Domain\Repository;

use App\Book\Domain\Model\Book;
use App\Common\Domain\Model\ValueObject\Uuid;

interface BookRepositoryInterface
{
    public function persist(Book $book): void;

    public function removeByUuid(Uuid $uuid): void;
}
