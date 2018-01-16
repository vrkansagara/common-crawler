<?php

namespace CommonCrawl\Factory;


use CommonCrawl\Service\IndexService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class IndexServiceFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new IndexService($serviceLocator->get('CommonCrawl\Mapper\IndexMapperInterface'));
    }
}