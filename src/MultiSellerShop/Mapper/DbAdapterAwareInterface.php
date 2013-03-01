<?php

namespace MultiSellerShop\Mapper;

use Zend\Db\Adapter\Adapter;

/**
 * Description of DbAdapterAwareInterface
 *
 * @author mhrilwan
 */
interface DbAdapterAwareInterface 
{
    public function getDbAdapter();
    public function setDbAdapter(Adapter $dbAdapter);
}

?>
