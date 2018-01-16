<?php
return array(
    'CommonCrawl' => array(
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
            'CommonCrawl\Controller\Index' => 'CommonCrawl\Factory\IndexFactory',
            'CommonCrawl\Console\Index' => 'CommonCrawl\Factory\Console\IndexFactory',
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'CommonCrawl\Service\IndexServiceInterface' => 'CommonCrawl\Factory\IndexServiceFactory',
            'CommonCrawl\Mapper\IndexMapperInterface' => 'CommonCrawl\Factory\ZendDbSqlMapperFactory',
            'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory',
        ),


    ),
    'router' => array(
        'routes' => array(
            'commoncrawl' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/commoncrawl[/action/:action][/id/:id][/index/:index]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'CommonCrawl\Controller',
                        'controller' => 'Index',
                        'action' => 'index',
                    ),
                    'constraints' => array(
//                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
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
                'commoncrawl-ping' => array(
                    'options' => array(
                        'route' => 'commoncrawl [--ping|-p] [--list|-l] [--insert|-i] [--verbose|-v] [--flush|-f] [--active|-a] [--inactive|-in] [--active-all|-al] [--inactive-all|-inl] [INDEXID] ',
                        'defaults' => array(
                            'controller' => 'CommonCrawl\Console\Index',
                            'action' => 'index'
                        )
                    )
                )
            )
        )
    ),
);
