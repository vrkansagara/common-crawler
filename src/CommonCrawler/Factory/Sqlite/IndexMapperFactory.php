<?php

namespace CommonCrawler\Factory\Sqlite;

use CommonCrawler\Mapper\Sqlite\IndexMapper;
use CommonCrawler\Model\Index;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\Hydrator\ClassMethods;


class IndexMapperFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $dbAdapter = array(
            'driver' => 'Pdo_Sqlite',
            'database' => __DIR__ . '/../../../../data/index.db'
        );
        $adapter = new \Zend\Db\Adapter\Adapter($dbAdapter);

        return new IndexMapper(
            $adapter,
            new ClassMethods(),
            new Index()
        );
    }
}