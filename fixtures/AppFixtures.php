<?php

declare(strict_types=1);

namespace DataFixtures;

use DataFixtures\Book\BookFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

final class AppFixtures extends Fixture implements DependentFixtureInterface
{
    #[\Override]
    public function load(ObjectManager $objectManager): void {}

    #[\Override]
    /**
     * @return string<class-string>[]
     */
    public function getDependencies(): array
    {
        return [
            BookFixtures::class,
        ];
    }
}
