<?php

declare(strict_types=1);

namespace App\Common\Application\Bus\Command;

interface CommandBus
{
    public function dispatch(CommandInterfaceInterface $commandInterface): void;
}
