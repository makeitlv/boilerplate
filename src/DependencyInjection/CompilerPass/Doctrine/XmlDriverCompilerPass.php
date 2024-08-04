<?php

declare(strict_types=1);

namespace App\DependencyInjection\CompilerPass\Doctrine;

use Doctrine\ORM\Mapping\Driver\SimplifiedXmlDriver;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

final class XmlDriverCompilerPass implements CompilerPassInterface
{
    #[\Override]
    public function process(ContainerBuilder $containerBuilder): void
    {
        $definition = $containerBuilder->findDefinition('doctrine.orm.default_metadata_driver');

        /** @var string $projectDir */
        $projectDir = $containerBuilder->getParameter('kernel.project_dir');

        $mappingPaths = $this->getMappingPaths($projectDir . '/src');

        foreach ($mappingPaths as $namespace => $path) {
            $xmlDriverDef = new Definition(SimplifiedXmlDriver::class, [[$path => $namespace]]);
            $driverServiceId = 'doctrine.orm.xml_driver.' . md5($path);

            $containerBuilder->setDefinition($driverServiceId, $xmlDriverDef);

            $definition->addMethodCall('addDriver', [
                new Reference($driverServiceId),
                $namespace,
            ]);
        }
    }

    /**
     * @return array<string, string>
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

            if ($file->getExtension() === 'xml') {
                $relativePath = str_replace($srcDir . '/', '', $file->getPath());
                $parts = explode('/', $relativePath);
                $domain = $parts[0];

                $mappingPaths[sprintf('App\%s\Domain\Model', $domain)] = $file->getPath();
            }
        }

        return $mappingPaths;
    }
}
