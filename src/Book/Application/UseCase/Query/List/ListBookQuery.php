<?php

declare(strict_types=1);

namespace App\Book\Application\UseCase\Query\List;

use App\Common\Application\Bus\Query\QueryInterface;
use App\Common\Domain\ReadModel\ValueObject\Limit;
use App\Common\Domain\ReadModel\ValueObject\Page;

final readonly class ListBookQuery implements QueryInterface
{
    public function __construct(
        public Page $page = new Page(),
        public Limit $limit = new Limit(),
    ) {}
}
