<?php

namespace CommonCrawler\Factory;

use CommonCrawler\Mapper\ZendDbSqlMapper;
use CommonCrawler\Model\Index;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\Hydrator\ClassMethods;


class ZendDbSqlMapperFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new ZendDbSqlMapper(
            $serviceLocator->get('Zend\Db\Adapter\Adapter'),
            new ClassMethods(),
            new Index(),
            $serviceLocator->get('Config')
        );
    }
}