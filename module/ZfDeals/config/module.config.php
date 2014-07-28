<?php
return array(
    // admin path
    'router' => array(
        'routes' => array(
            // admin routes
            'zf-deals\admin\home' => array(
                'type'    => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/deals/admin',
                    'defaults' => array(
                        'controller' => 'ZfDeals\Controller\Admin',
                        'action'     => 'index',
                    ),
                ),
            ),
            // add product routes
            'zf-deals\admin\product\add' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/deals/admin/product/add',
                    'defaults' => array(
                        'controller' => 'ZfDeals\Controller\Admin',
                        'action'     => 'add-product',
                    ),
                ),
            ),
        ),
    ),

    // admin Controller
    'controllers' => array(
        /*
        'invokables' => array(
            'ZfDeals\Controller\Admin' => 'ZfDeals\Controller\AdminController'
        ),
        */
        'factories' => array(
            'ZfDeals\Controller\Admin' => 'ZfDeals\Controller\AdminControllerFactory'
        ),
    ),

    // for admin layout
    'view_manager' => array(
        'template_map' => array(
            'zf-deals/layout/admin' => __DIR__ . '/../view/zf-deals/layout/admin.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    // db connection part 1/2 next on config/autoload/local.php
    'service_manager' => array(
        'factories' => array(
            'Zend\Db\Adapter\Adapter' => function ($sm) {
                $config = $sm->get('Config');
                $dbParams = $config['dbParams'];

                return new Zend\Db\Adapter\Adapter(array(
                    'driver'    => 'pdo',
                    'dsn'       => 'mysql:dbname='.$dbParams['database'].';host='.$dbParams['hostname'],
                    'database'  => $dbParams['database'],
                    'username'  => $dbParams['username'],
                    'password'  => $dbParams['password'],
                    'hostname'  => $dbParams['hostname'],
                ));
            },
            'ZfDeals\Mapper\Product' => function ($sm) {
                return new \ZfDeals\Mapper\Product(
                    $sm->get('Zend\Db\Adapter\Adapter')
                );
            },
        ),
    ),
);