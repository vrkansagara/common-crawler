<?php

namespace CommonCrawl\Factory\Console;


use CommonCrawl\Console\IndexController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class IndexFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $realServiceLocator = $serviceLocator->getServiceLocator();
        $indexService = $realServiceLocator->get('CommonCrawl\Service\IndexServiceInterface');

        return new IndexController($indexService);
    }
}