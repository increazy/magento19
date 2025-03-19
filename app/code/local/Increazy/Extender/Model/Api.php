<?php
class Increazy_Extender_Model_Api extends Mage_Api_Model_Resource_Abstract
{
    public function getFullCategoryTree($sessionId)
    {
        // Verifica a sessão
        $this->_initSession($sessionId);

        // Obtém a árvore de categorias
        $categoryTree = Mage::getModel('catalog/category')->getTreeModel()->load();
        $rootCategoryId = Mage::app()->getStore()->getRootCategoryId();
        $rootCategory = Mage::getModel('catalog/category')->load($rootCategoryId);

        return $this->_buildFullCategoryTree($rootCategory);
    }

    protected function _buildFullCategoryTree($category)
    {
        $result = array(
            'category_id' => $category->getId(),
            'name' => $category->getName(),
            'is_active' => $category->getIsActive(),
            'position' => $category->getPosition(),
            'level' => $category->getLevel(),
            'parent_id' => $category->getParentId(),
            'all_attributes' => $category->getData(), // Todos os atributos da categoria
            'children' => array()
        );

        $children = $category->getChildrenCategories();
        foreach ($children as $child) {
            $childCategory = Mage::getModel('catalog/category')->load($child->getId());
            $result['children'][] = $this->_buildFullCategoryTree($childCategory);
        }

        return $result;
    }
}