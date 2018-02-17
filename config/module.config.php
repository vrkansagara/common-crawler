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
        ),
        'pageSize' => 3
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    'controllers' => array(
        'factories' => array(
            'CommonCrawler\Controller\Index' => 'CommonCrawler\Factory\IndexFactory',
            'CommonCrawler\Console\Index' => 'CommonCrawler\Factory\IndexFactory',

            'CommonCrawler\Controller\Query' => 'CommonCrawler\Factory\QueryFactory',
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'CommonCrawler\Service\QueryServiceInterface' => 'CommonCrawler\Factory\QueryServiceFactory',
            'CommonCrawler\Mapper\QueryMapperInterface' => 'CommonCrawler\Factory\Sql\QueryMapperFactory',//Uncomment while you want to use db-engine as Sqlite.

            'CommonCrawler\Service\IndexServiceInterface' => 'CommonCrawler\Factory\IndexServiceFactory',
            'CommonCrawler\Mapper\IndexMapperInterface' => 'CommonCrawler\Factory\Sql\IndexMapperFactory',//Uncomment while you want to use db-engine as Sqlite.

            'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory', // <-- Only Used to map dbAdepter
        ),


    ),
    'router' => array(
        'routes' => array(
            'commoncrawler.index' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/commoncrawler/index[/action/:action][/id/:id][/index/:index][/status/:status]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'CommonCrawler\Controller',
                        'controller' => 'Index',
                        'action' => 'index',
                    ),
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'status' => '[0-1]',
                    ),
                ),
                'may_terminate' => true,
            ),
            'commoncrawler.query' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/commoncrawler/query[/action/:action][/id/:id][/query/:query][/status/:status]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'CommonCrawler\Controller',
                        'controller' => 'Query',
                        'action' => 'index',
                    ),
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]*',
                        'status' => '[0-1]',
                    ),
                ),
                'may_terminate' => true,
            )

        ),
    ),

    'console' => array(
        'router' => array(
            'routes' => array(
                'commoncrawler' => array(
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
