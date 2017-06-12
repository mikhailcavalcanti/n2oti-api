<?php

use Dflydev\Provider\DoctrineOrm\DoctrineOrmServiceProvider;
use Silex\Provider\DoctrineServiceProvider;

$mappings = array();
$addMapping = function ($namespace, $path) use (&$mappings) {
    array_push($mappings, array('type' => 'annotation', 'namespace' => $namespace, 'path' => $path, 'use_simple_annotation_reader' => false));
};

$addMapping('N2oti\Api\Entidade', __DIR__ . '/../src/N2oti/Api/Entidade');

$app->register(new DoctrineServiceProvider(), array(
    'db.options' => array(
        'driver' => $app['config']['database']['driver'],
        'host' => $app['config']['database']['host'],
        'charset' => 'utf8',
        'dbname' => $app['config']['database']['dbname'],
        'user' => $app['config']['database']['user'],
        'password' => $app['config']['database']['password'],
    ),
));

$app->register(new DoctrineOrmServiceProvider(), array(
    'orm.auto_generate_proxies' => $app['debug'],
    'orm.proxies_dir' => __DIR__ . '/../cache/doctrine/proxies',
    'orm.em.options' => array(
        'mappings' => $mappings,
    ),
));
