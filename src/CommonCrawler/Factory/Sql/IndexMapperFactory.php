<?php

namespace CommonCrawler\Factory\Sql;

use CommonCrawler\Mapper\Sql\IndexMapper;
use CommonCrawler\Model\Index;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\Hydrator\ClassMethods;


class IndexMapperFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new IndexMapper(
            $serviceLocator->get('Zend\Db\Adapter\Adapter'),
            new ClassMethods(),
            new Index(),
            $serviceLocator->get('config')
        );
    }
}