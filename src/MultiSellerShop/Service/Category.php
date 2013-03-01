<?php
namespace MultiSellerShop\Service;

/**
 * Description of Category
 *
 * @author mhrilwan
 */
class Category extends AbstractService 
{
    protected $entityMapper = 'mss_category_mapper';
    protected $productService;
    protected $productUomService;
    protected $productImageService;
    protected $optionService;
    
    
    
//    public function getCategoriesForNavigation()
//    {
//        $categories = $this->getChildCategories(null);
//        foreach ($categories as $cat) {
//            $cats = $this->getChildCategories($cat->getCategoryId());
//            $cat->setCategories($cats);
//        }
//        return $categories;
//    }
    
    
    public function getCategoryforView($categoryId, $paginationOptions=null)
    {
        $category = $this->findById($categoryId);
        if (!$category) return;

        $categories = $this->getChildCategories($categoryId);
//        $products = $this->getProductService()->getByCategoryId($categoryId, $paginationOptions);
//        foreach($products as $product){
//            $product->setImages($this->getProductImageService()->getImages('product', $product->getProductId()));
//            $product->setUoms($this->getProductUomService()->getByProductId($product->getProductId()));
//            $product->setOptions($this->getOptionService()->getByProductId($product->getProductId(), true, true));
//        }
        $category->setCategories($categories);
//        $category->setProducts($products);

        return $category;
    }
    
    public function findById($categoryId)
    {
        return $this->find(array('category_id' => $categoryId));
    }
    
    public function getChildCategories($categoryId)
    {
        return $this->getEntityMapper()->getChildCategories($categoryId);
    }
    
    /**
     * @return productService
     */
    public function getProductService()
    {
        if (null === $this->productService) {
            $this->productService = $this->getServiceLocator()->get('mss_product_service');
        }
        return $this->productService;
    }
    
    /**
     * @param $productService
     * @return self
     */
    public function setProductService($productService)
    {
        $this->productService = $productService;
        return $this;
    }
    
}

?>
