<?php

declare(strict_types=1);

namespace App\Tests\Browser;

use Symfony\Component\Panther\PantherTestCase;

/**
 * @internal
 *
 * @coversNothing
 */
class ExampleTest extends PantherTestCase
{
    public function testSomething(): void
    {
        $client = static::createPantherClient();
        $client->request('GET', '/');

        self::assertSelectorTextContains('h1', 'Hello World');
    }
}
