<?php

class Increazy_Extender_Model_Category_Api extends Mage_Catalog_Model_Category_Api
{
    public function catalogCategoryTreeFull($parentId = null, $store = null)
    {
        if (is_null($parentId)) {
            $parentId = Mage::app()->getStore($store)->getRootCategoryId();
        }

        return $this->_getCategoryTree($parentId, $store);
    }

    protected function _getCategoryTree($parentId, $store)
    {
        $tree = Mage::getModel('catalog/category')->getCollection()
            ->setStoreId($store)
            ->addAttributeToSelect('*')
            ->addAttributeToFilter('parent_id', $parentId)
            ->addIsActiveFilter();

        $categories = [];
        foreach ($tree as $category) {
            $categoryData = $category->getData();
            $categoryData['children'] = $this->_getCategoryTree($category->getId(), $store);
            $categories[] = $categoryData;
        }

        return $categories;
    }
}
