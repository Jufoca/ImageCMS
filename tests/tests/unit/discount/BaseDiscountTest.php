<?php

namespace mod_discount\classes;

require_once realpath(dirname(__FILE__) . '/../../..') . '/enviroment.php';

doLogin();

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.1 on 2013-07-02 at 10:45:08.
 */
class BaseDiscountTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var BaseDiscount
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $this->object = new BaseDiscount();
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {
        
    }

    /**
     * @covers mod_discount\classes\BaseDiscount::check_module_install
     */
    public function testCheck_module_install() {
        $this->assertTrue($this->object->check_module_install());
    }

    /**
     * @covers mod_discount\classes\BaseDiscount::get_user_id
     */
    public function testGet_user_id() {
        $this->assertEquals(50,$this->object->get_user_id());
    }

    /**
     * @covers mod_discount\classes\BaseDiscount::get_user_group_id

     */
    public function testGet_user_group_id() {
        $this->assertEquals(1,$this->object->get_user_group_id());
    }

    /**
     * @covers mod_discount\classes\BaseDiscount::get_cart_data
     */
    public function testGet_cart_data() {
        
        $this->assertInternalType('array',  $this->object->get_cart_data());
        $this->assertEquals(2, count($this->object->get_cart_data()));


    }

    /**
     * @covers mod_discount\classes\BaseDiscount::get_amout_user
     */
    public function testGet_amout_user() {
        
        $this->assertEquals(392065.56, $this->object->get_amout_user($this->object->get_user_id()));
    }

    /**
     * @covers mod_discount\classes\BaseDiscount::get_total_price
     */
    public function testGet_total_price() {
        
        $this->assertEquals(125998.80, $this->object->get_total_price($this->object->get_cart_data()));
    }

    /**
     * @covers mod_discount\classes\BaseDiscount::get_all_discount
     */
    public function testGet_all_discount() {
        
        $this->assertInternalType('array',  $this->object->get_all_discount());
        $arr = $this->object->get_all_discount();      
        $this->assertEquals(2, count($arr));
        $this->assertArrayHasKey('type_discount', $arr[0]);
        $this->assertArrayHasKey('type_value', $arr[0]);
        $this->assertArrayHasKey('value', $arr[0]);
        $this->assertArrayHasKey('discount_id', $arr[0]);
    }

    /**
     * @covers mod_discount\classes\BaseDiscount::collect_type
     */
    public function testCollect_type() {
        
        $discount_type = $this->object->collect_type($this->object->get_all_discount());
        $this->assertArrayHasKey('product', $discount_type);
        $this->assertArrayHasKey('brand', $discount_type);
        $this->assertEquals(1, count($discount_type['group_user']));
        
    }

    /**
     * @covers mod_discount\classes\BaseDiscount::get_max_discount
     */
    public function testGet_max_discount() {
        
        $arr_disc = array(
            array('type_value' => 2, 'value' => 200),
            array('type_value' => 1, 'value' => 20),
            array('type_value' => 1, 'value' => 10),
            array('type_value' => 2, 'value' => 120)
        );
        
        $price = 210;
        
        $disc = $this->object->get_max_discount($arr_disc, $price);
        
        $this->assertEquals(200, $disc['value']);
        
        
    }

    /**
     * @covers mod_discount\classes\BaseDiscount::get_discount_value
     */
    public function testGet_discount_value() {
        
        $arr_disc = 
            array('type_value' => 1, 'value' => 20);
        
        $price = 210;
        
        $disc = $this->object->get_discount_value($arr_disc, $price);
        
        $this->assertEquals(42, $disc);
    }

    /**
     * @covers mod_discount\classes\BaseDiscount::updatediskapply
     */
    public function testUpdatediskapply() {
        
        $this->assertTrue($this->object->updatediskapply('qvu102pfrn5m0552'));
    }

}
