<?php

declare(strict_types=1);

use App\Complying\Kernel;
use Doctrine\DBAL\Platforms\PostgreSQLPlatform;
use Doctrine\DBAL\Platforms\SQLitePlatform;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Component\Dotenv\Dotenv;

require dirname(__DIR__, 2).'/vendor/autoload.php';

$root = dirname(__DIR__, 2);
(new Dotenv())->bootEnv($root.'/.env');

$_SERVER['APP_ENV'] = $_ENV['APP_ENV'] = 'test';
$_SERVER['APP_DEBUG'] = $_ENV['APP_DEBUG'] = '1';

$kernel = new Kernel('test', true);
$kernel->boot();

$entityManager = $kernel->getContainer()->get('doctrine')->getManager();
if (!$entityManager instanceof EntityManagerInterface) {
    throw new RuntimeException('Default Doctrine manager is not an ORM entity manager.');
}

$metadata = $entityManager->getMetadataFactory()->getAllMetadata();
$schema = (new SchemaTool($entityManager))->getSchemaFromMetadata($metadata);

$platforms = [
    'postgresql' => new PostgreSQLPlatform(),
    'sqlite' => new SQLitePlatform(),
];

foreach ($platforms as $name => $platform) {
    fwrite(STDOUT, sprintf("=== %s ===\n", strtoupper($name)));
    foreach ($schema->toSql($platform) as $sql) {
        fwrite(STDOUT, $sql.";\n");
    }
}

$kernel->shutdown();
