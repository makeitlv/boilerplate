<?php

declare(strict_types=1);

namespace App;

use App\DependencyInjection\CompilerPass\Doctrine\DoctrineMappingCompilerPass;
use App\DependencyInjection\CompilerPass\Validator\ValidatorMappingCompilerPass;
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
        $containerBuilder->addCompilerPass(new DoctrineMappingCompilerPass());
        $containerBuilder->addCompilerPass(new ValidatorMappingCompilerPass());
    }
}
