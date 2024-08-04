<?php

declare(strict_types=1);

namespace App;

use App\DependencyInjection\CompilerPass\Doctrine\XmlDriverCompilerPass;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

final class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    #[\Override]
    protected function build(ContainerBuilder $containerBuilder): void
    {
        parent::build($containerBuilder);
        $containerBuilder->addCompilerPass(new XmlDriverCompilerPass());
    }
}
