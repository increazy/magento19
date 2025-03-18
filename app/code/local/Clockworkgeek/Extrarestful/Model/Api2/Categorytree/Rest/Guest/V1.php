<?php

/**
 * Inactive categories cannot be seen by public users
 *
 * @author Daniel Deady <daniel@clockworkgeek.com>
 * @license MIT
 */
class Clockworkgeek_Extrarestful_Model_Api2_Categorytree_Rest_Guest_V1
extends Clockworkgeek_Extrarestful_Model_Api2_Categorytree
{

    /**
     * Guests may not see inactive categories
     *
     * {@inheritDoc}
     * @see Clockworkgeek_Extrarestful_Model_Api2_Categorytree::_getCollection()
     */
    protected function _getCollection()
    {
        $categories = parent::_getCollection();
        $categories->addIsActiveFilter();
        return $categories;
    }
}
