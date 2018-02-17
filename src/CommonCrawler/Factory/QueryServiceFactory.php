<?php

namespace CommonCrawler\Factory;


use CommonCrawler\Service\QueryService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class QueryServiceFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $indexMpper = $serviceLocator->get('CommonCrawler\Mapper\QueryMapperInterface');
        $config = $serviceLocator->get('config');
        return new QueryService($indexMpper, $config);
    }
}