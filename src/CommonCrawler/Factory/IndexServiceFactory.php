<?php

namespace CommonCrawler\Factory;


use CommonCrawler\Service\IndexService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class IndexServiceFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new IndexService($serviceLocator->get('CommonCrawler\Mapper\IndexMapperInterface'));
    }
}