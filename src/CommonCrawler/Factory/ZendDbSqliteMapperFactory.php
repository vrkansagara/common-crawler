<?php

namespace CommonCrawl\Factory;

use CommonCrawl\Mapper\ZendDbSqliteMapper;
use CommonCrawl\Model\Index;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\Hydrator\ClassMethods;


class ZendDbSqliteMapperFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $dbAdapter = array(
            'driver' => 'Pdo_Sqlite',
            'database' => __DIR__ . '/../../../data/index.db'
        );
        $adapter = new \Zend\Db\Adapter\Adapter($dbAdapter);

        return new ZendDbSqliteMapper(
            $adapter,
            new ClassMethods(),
            new Index()
        );
    }
}