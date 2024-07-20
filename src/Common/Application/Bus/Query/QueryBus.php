<?php

declare(strict_types=1);

namespace App\Common\Application\Bus\Query;

interface QueryBus
{
    public function ask(Query $query): mixed;
}
