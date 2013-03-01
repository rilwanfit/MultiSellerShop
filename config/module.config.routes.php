<?php

return array(

    'router' => array(
        'routes' => array(
            'category' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/category[/:id]',
                    'constraints' => array(
                        'id'     => '[0-9]+',
                    ),
                     'defaults' => array(
                        'controller' => 'MultiSellerShop\Controller\Category',
                        'action'     => 'index',
                    ),
                ),
            ),
            /**
             * Start to overwrite zfcuser's route.
             * Make sure the module in which you provide this config is registered later than ZfcUser!
             */
            'zfcuser' => array(
                'options' => array(
                    'route' => '/account',
                ),
            ),
            'product' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/product[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'MultiSellerShop\Controller',
                        'controller' => 'Product',
                        'action' => 'index',
                    ),
                ),
            ),
        ),
    ),
   
    'view_manager' => array(
        'template_path_stack' => array(
           'multi-seller-shop' =>  __DIR__ . '/../view',
        ),
    ),
    
);
