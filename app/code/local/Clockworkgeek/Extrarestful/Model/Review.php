<?php

/**
 * @author Daniel Deady <daniel@clockworkgeek.com>
 * @license MIT
 */
class Clockworkgeek_Extrarestful_Model_Review extends Mage_Review_Model_Review
{

    protected function _construct()
    {
        $this->_init('extrarestful/review');
    }
}
