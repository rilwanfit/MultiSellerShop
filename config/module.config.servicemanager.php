<?php

return array(
    'service_manager' => array(
        'shared' => array(
         ),
        'invokables' => array(
            'mss_category_service' => 'MultiSellerShop\Service\Category',
            'mss_category_mapper' => 'MultiSellerShop\Mapper\Category',
            'MultiSellerShop\Controller\Product' => 'MultiSellerShop\Controller\ProductController'
        ),
    )    
);
