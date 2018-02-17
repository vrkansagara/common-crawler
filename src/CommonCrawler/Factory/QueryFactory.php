<?php
/**
 * Created by PhpStorm.
 * User: vallabh
 * Date: 03/02/18
 * Time: 4:06 PM
 */

namespace CommonCrawler\Factory;


use CommonCrawler\Controller\QueryController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class QueryFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $realServiceLocator = $serviceLocator->getServiceLocator();
        $queryService = $realServiceLocator->get('CommonCrawler\Service\QueryServiceInterface');
        return new QueryController($queryService);
    }
}