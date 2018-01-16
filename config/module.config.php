<?php
return array(
    'CommonCrawler' => array(
        'options' => array(
            'index_collections' => array(
                'json' => 'http://index.commoncrawl.org/collinfo.json',
                'url' => array(
                    'home' => 'http://index.commoncrawl.org',
                    'amazon' => 'https://commoncrawl.s3.amazonaws.com/cc-index/collections/index.html',
                ),
            ),

        ),
        'data_dir' => __DIR__ . '/../data/index',
        'db' => array(
            'tables' => array(
                'index' => 'common_index'
            ),
            'drop_table_if_exists' => true
        )
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    'controllers' => array(
        'invokables' => array(),
        'factories' => array(
            'CommonCrawler\Controller\Index' => 'CommonCrawler\Factory\IndexFactory',
            'CommonCrawler\Console\Index' => 'CommonCrawler\Factory\Console\IndexFactory',
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            //            'CommonCrawler\Mapper\IndexMapperInterface' => 'CommonCrawler\Factory\ZendDbSqliteMapperFactory',
            'CommonCrawler\Service\IndexServiceInterface' => 'CommonCrawler\Factory\IndexServiceFactory',
            'CommonCrawler\Mapper\IndexMapperInterface' => 'CommonCrawler\Factory\ZendDbSqlMapperFactory',
            'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory',
        ),


    ),
    'router' => array(
        'routes' => array(
            'commoncrawler' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/commoncrawler[/action/:action][/id/:id][/index/:index]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'CommonCrawler\Controller',
                        'controller' => 'Index',
                        'action' => 'index',
                    ),
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                ),
                'may_terminate' => true,
            )
        ),
    ),

    'console' => array(
        'router' => array(
            'routes' => array(
                'commoncrawler-ping' => array(
                    'options' => array(
                        'route' => 'commoncrawler [--ping|-p] [--list|-l] [--insert|-i] [--verbose|-v] [--flush|-f] [--active|-a] [--inactive|-in] [--active-all|-al] [--inactive-all|-inl] [INDEXID] ',
                        'defaults' => array(
                            'controller' => 'CommonCrawler\Console\Index',
                            'action' => 'index'
                        )
                    )
                )
            )
        )
    ),
);
