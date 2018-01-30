<?php

namespace CommonCrawler\Factory;


use CommonCrawler\Service\IndexService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class IndexServiceFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $indexMpper = $serviceLocator->get('CommonCrawler\Mapper\IndexMapperInterface');
        $config = $serviceLocator->get('config');
        return new IndexService($indexMpper, $config);
    }
}