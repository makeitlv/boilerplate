<?php

declare(strict_types=1);

use App\Kernel;
use DG\BypassFinals;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Dotenv\Dotenv;

require dirname(__DIR__) . '/vendor/autoload.php';

if (file_exists(dirname(__DIR__) . '/config/bootstrap.php')) {
    require dirname(__DIR__) . '/config/bootstrap.php';
} elseif (method_exists(Dotenv::class, 'bootEnv')) {
    (new Dotenv())->bootEnv(dirname(__DIR__) . '/.env');
}

BypassFinals::enable();

$kernel = new Kernel('test', true);
$kernel->boot();

$application = new Application($kernel);
$application->setCatchExceptions(false);
$application->setAutoExit(false);

$application->run(new ArrayInput([
    'command' => 'doctrine:database:drop',
    '--if-exists' => '1',
    '--force' => '1',
]));

$application->run(new ArrayInput([
    'command' => 'doctrine:database:create',
    '--env' => 'test',
    '--if-not-exists' => true,
]));

$application->run(new ArrayInput([
    'command' => 'doctrine:schema:drop',
    '--env' => 'test',
    '--force' => true,
]));

$application->run(new ArrayInput([
    'command' => 'doctrine:schema:create',
    '--env' => 'test',
]));

$kernel->shutdown();
