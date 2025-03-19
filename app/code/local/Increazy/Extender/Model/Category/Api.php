<?php

class Increazy_Extender_Model_Category_Api extends Mage_Catalog_Model_Category_Api
{
    public function catalogCategoryTreeFull($sessionId, $parentId = null, $store = null)
    {
        $this->_checkSession($sessionId);

        if (is_null($parentId)) {
            $parentId = Mage::app()->getStore($store)->getRootCategoryId();
        }

        return $this->_getCategoryTree($parentId, $store);
    }

    protected function _getCategoryTree($parentId, $store)
    {
        $categories = Mage::getModel('catalog/category')->getCollection()
            ->setStoreId($store)
            ->addAttributeToSelect('*')
            ->addAttributeToFilter('parent_id', $parentId)
            ->addIsActiveFilter();

        $result = [];
        foreach ($categories as $category) {
            $categoryData = $category->getData();
            $categoryData['children'] = $this->_getCategoryTree($category->getId(), $store);
            $result[] = $categoryData;
        }

        return $result;
    }

    protected function _checkSession($sessionId)
    {
        $user = Mage::getModel('api/session')->loginBySessionId($sessionId);
        if (!$user) {
            throw new Mage_Api_Exception('session_expired', 'Invalid API session.');
        }
    }
}
