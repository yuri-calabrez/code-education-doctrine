<?php
require 'vendor/autoload.php';

use Silex\Application;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\RoutingServiceProvider;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Events;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\Mapping\Driver\DriverChain;
use Doctrine\Common\EventManager;
use Doctrine\Common\Cache\ArrayCache as Cache;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\Common\Annotations\CachedReader;
use Doctrine\Common\ClassLoader;

$cache = new Cache();
$annotationReader = new AnnotationReader();

$cachedAnnotationReader = new CachedReader($annotationReader, $cache);

$annotationDriver = new AnnotationDriver($cachedAnnotationReader, array(__DIR__ . DIRECTORY_SEPARATOR . 'src'));

$driverChain = new DriverChain();
$driverChain->addDriver($annotationDriver, 'Code');

$config = new Configuration;
$config->setProxyDir('/tmp');
$config->setProxyNamespace('Proxy');
$config->setAutoGenerateProxyClasses(true); // this can be based on production config.
// register metadata driver
$config->setMetadataDriverImpl($driverChain);
// use our allready initialized cache driver
$config->setMetadataCacheImpl($cache);
$config->setQueryCacheImpl($cache);

AnnotationRegistry::registerFile(__DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'doctrine' . DIRECTORY_SEPARATOR . 'orm' . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'Doctrine' . DIRECTORY_SEPARATOR . 'ORM' . DIRECTORY_SEPARATOR . 'Mapping' . DIRECTORY_SEPARATOR . 'Driver' . DIRECTORY_SEPARATOR . 'DoctrineAnnotations.php');

$evm = new EventManager();
$em = EntityManager::create([
    'driver' => 'pdo_mysql',
    'host' => 'localhost',
    'port' => '3306',
    'user' => 'root',
    'password' => '',
    'dbname' => 'trilhando_doctrine',
], $config, $evm);


$app = new Application();
$app['debug'] = true;

$app->register(new TwigServiceProvider(), array(
    'twig.path' => __DIR__ . '/views'
));

$app->register(new RoutingServiceProvider());