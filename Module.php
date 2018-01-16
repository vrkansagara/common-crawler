<?php

namespace CommonCrawl;

use Zend\Console\Adapter\AdapterInterface;
use Zend\EventManager\StaticEventManager;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ConsoleUsageProviderInterface;
use Zend\ModuleManager\ModuleManager;


class Module implements AutoloaderProviderInterface, ConfigProviderInterface, ConsoleUsageProviderInterface
{

    /**
     * Returns configuration to merge with application configuration
     *
     * @return array|\Traversable
     */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }


    /**
     * Return an array for passing to Zend\Loader\AutoloaderFactory.
     *
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    // Autoload all classes from namespace 'CommonCrawl' from '/module/CommonCrawl/src/CommonCrawl'
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                )
            )
        );
    }

    public function getConsoleUsage(AdapterInterface $console)
    {
        return array(
            'commoncrawl' => 'Common Crawl',
            array('--ping|-p', 'Ping'),
            array('--list|-l', 'List all index(s)'),
            array('--insert|-i', 'Fetch index and insert into index table'),
            array('--flush|-f', 'Remove all indexes'),
            array('--verbose|-v', 'Verbosity.'),
        );
    }

}