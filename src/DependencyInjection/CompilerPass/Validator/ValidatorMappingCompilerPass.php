<?php

declare(strict_types=1);

namespace App\DependencyInjection\CompilerPass\Validator;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class ValidatorMappingCompilerPass implements CompilerPassInterface
{
    #[\Override]
    public function process(ContainerBuilder $containerBuilder): void
    {
        /** @var string $projectDir */
        $projectDir = $containerBuilder->getParameter('kernel.project_dir');

        $mappingPaths = $this->getMappingPaths($projectDir . '/src');

        if ($mappingPaths === []) {
            return;
        }

        if (! $containerBuilder->hasDefinition('validator.builder')) {
            return;
        }

        $validatorDefinition = $containerBuilder->getDefinition('validator.builder');

        foreach ($mappingPaths as $mappingPath) {
            $validatorDefinition->addMethodCall('addXmlMapping', [$mappingPath]);
        }
    }

    /**
     * @return array<int, string>
     */
    private function getMappingPaths(string $srcDir): array
    {
        $mappingPaths = [];

        $directoryIterator = new \RecursiveDirectoryIterator($srcDir);
        $iterator = new \RecursiveIteratorIterator($directoryIterator);

        /** @var \SplFileInfo $file */
        foreach ($iterator as $file) {
            if ($file->isDir()) {
                continue;
            }

            if ($file->getExtension() === 'xml' && str_contains($file->getPath(), 'Mapping/Validator')) {
                $mappingPaths[] = $file->getPathname();
            }
        }

        return $mappingPaths;
    }
}
