<?php

namespace CommonCrawl\Factory;


use CommonCrawl\Controller\IndexController;
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