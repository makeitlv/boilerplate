<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\Query\DBAL;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

abstract readonly class AbstractDBALQuery
{
    protected QueryBuilder $queryBuilder;

    public function __construct(
        private Connection $connection,
    ) {
        $this->queryBuilder = $this->connection->createQueryBuilder();
    }
}
