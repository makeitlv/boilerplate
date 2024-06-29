<?php

declare(strict_types=1);

namespace App\Tests\Feature;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

/**
 * @internal
 *
 * @coversNothing
 */
class ExampleTest extends WebTestCase
{
    public function testSomething(): void
    {
        $kernelBrowser = static::createClient();
        $kernelBrowser->request(Request::METHOD_GET, '/');

        self::assertResponseIsSuccessful();
        self::assertSelectorTextContains('h1', 'Hello World');
    }
}
