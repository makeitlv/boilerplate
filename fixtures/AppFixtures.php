<?php

declare(strict_types=1);

namespace DataFixtures;

use DataFixtures\Book\BookFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

final class AppFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void {}

    #[\Override]
    public function getDependencies(): array
    {
        return [
            BookFixtures::class,
        ];
    }
}
