<?php

namespace CommonCrawler\Factory\Sql;

use CommonCrawler\Mapper\Sql\QueryMapper;
use CommonCrawler\Model\Query;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\Hydrator\ClassMethods;


class QueryMapperFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new QueryMapper(
            $serviceLocator->get('Zend\Db\Adapter\Adapter'),
            new ClassMethods(),
            new Query(),
            $serviceLocator->get('config')
        );
    }
}