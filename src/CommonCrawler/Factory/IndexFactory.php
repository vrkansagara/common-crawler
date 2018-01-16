<?php

namespace CommonCrawler\Factory;


use CommonCrawler\Controller\IndexController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class IndexFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $realServiceLocator = $serviceLocator->getServiceLocator();
        $indexService = $realServiceLocator->get('CommonCrawler\Service\IndexServiceInterface');

        return new IndexController($indexService);
    }
}