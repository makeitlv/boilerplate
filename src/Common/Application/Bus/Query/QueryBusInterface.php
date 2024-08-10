<?php

declare(strict_types=1);

namespace App\Common\Application\Bus\Query;

interface QueryBusInterface
{
    public function ask(QueryInterface $query): mixed;
}
