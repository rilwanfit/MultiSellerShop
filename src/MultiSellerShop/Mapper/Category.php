<?php

namespace MultiSellerShop\Mapper;

/**
 * Description of Category
 *
 * @author mhrilwan
 */
class Category extends AbstractMapper
{
    protected $tableName = 'mss_category';
    protected $relationalModel = '\MultiSellerShop\Model\Category\Relational';
    protected $dbModel = '\MultiSellerShop\Model\Category';
    protected $key = array('category_id');
    protected $dbFields = array('category_id', 'name', 'seo_title', 'description_html', 'image_file_name');
    
    public function find(array $data)
    {
        $select = $this->getSelect()
            ->where(array('category_id' => (int) $data['category_id']));
        return $this->selectOne($select);
    }
}

?>
