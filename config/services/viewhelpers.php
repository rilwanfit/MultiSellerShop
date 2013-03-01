<?php

use MultiSellerShop\Service\FormServiceAwareInterface;
use MultiSellerShop\View\Helper;

return array(
    'shared' => array(
        //note: this isnt currently working, and as a result, there are the wrong forms almost everywhere in the views :(
        //see github.com/zendframework/zf2 issue #3094
        'speckCatalogRenderForm' => false,
    ),
    'invokables' => array(
        'speckCatalogRenderChildren' => 'SpeckCatalog\View\Helper\ChildViewRenderer',
        'speckCatalogRenderForm'     => 'SpeckCatalog\View\Helper\RenderForm',
        'speckCatalogCart'           => 'SpeckCatalog\View\Helper\Cart',
    ),
    'factories' => array(
        'speckCatalogAdderHelper' => function($sm) {
            $sm = $sm->getServiceLocator();
            $options = $sm->get('speckcatalog_module_options');
            $helper = new Helper\AdderHelper;
            $helper->setPartialDir($options->getCatalogManagerPartialDir());
            return $helper;
        },
        'speckCatalogOptionImageUploader' => function ($sm) {
            $imageUploader = $sm->get('imageUploader');
            $element = array('name' => 'file_type', 'attributes' => array('value' => 'optionImage', 'type' => 'hidden'));
            $imageUploader->getForm()->add($element);
            return $imageUploader;
        },
        'speckCatalogManagerSideNav' => function ($sm) {
            $sm = $sm->getServiceLocator();
            $app = $sm->get('application');
            $routeMatch = $app->getMvcEvent()->getRouteMatch();
            $helper = new Helper\CatalogManagerSideNav();
            $helper->setRouteMatch($routeMatch);
            return $helper;
        },
        'speckCatalogProductImageUploader' => function ($sm) {
            $imageUploader = $sm->get('imageUploader');
            $element = array('name' => 'file_type', 'attributes' => array('value' => 'productImage', 'type' => 'hidden'));
            $imageUploader->getForm()->add($element);
            return $imageUploader;
        },
        'speckCatalogProductDocumentUploader' => function ($sm) {
            $uploader = $sm->get('imageUploader');
            $element = array('name' => 'file_type', 'attributes' => array('value' => 'productDocument', 'type' => 'hidden'));
            $uploader->getForm()->add($element);
            return $uploader;
        },
        'speckCatalogCategoryNav' => function ($sm) {
            $sm = $sm->getServiceLocator();
            $helper = new Helper\CategoryNav;
            return $helper->setCategoryService($sm->get('speckcatalog_category_service'));
        },
        'speckCatalogImage' => function ($sm) {
            $sm = $sm->getServiceLocator();
            $settings = $sm->get('speckcatalog_module_options');
            return new Helper\MediaUrl($settings, 'image');
        },
        'speckCatalogFeaturedProducts' => function ($sm) {
            $speckFeaturedProducts = $sm->get('speckFeaturedProducts');
            return $speckFeaturedProducts->setTemplate('/speck-catalog/product/feature-clip');
        },
    ),
    'initializers' => array(
        function($instance, $sm){
            if($instance instanceof FormServiceAwareInterface){
                var_dump($instance);die();
                $sm = $sm->getServiceLocator();
                $formService = $sm->get('speckcatalog_form_service');
                $instance->setFormService($formService);
            }
        },
    ),
);