<?php
/* SVN FILE: $Id: object.test.php 7295 2008-06-27 08:17:02Z gwoo $ */
/**
 * Short description for file.
 *
 * Long description for file
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) Tests <https://trac.cakephp.org/wiki/Developement/TestSuite>
 * Copyright 2005-2008, Cake Software Foundation, Inc.
 *								1785 E. Sahara Avenue, Suite 490-204
 *								Las Vegas, Nevada 89104
 *
 *  Licensed under The Open Group Test Suite License
 *  Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright		Copyright 2005-2008, Cake Software Foundation, Inc.
 * @link				https://trac.cakephp.org/wiki/Developement/TestSuite CakePHP(tm) Tests
 * @package			cake.tests
 * @subpackage		cake.tests.cases.libs
 * @since			CakePHP(tm) v 1.2.0.5432
 * @version			$Revision: 7295 $
 * @modifiedby		$LastChangedBy: gwoo $
 * @lastmodified	$Date: 2008-06-27 03:17:02 -0500 (Fri, 27 Jun 2008) $
 * @license			http://www.opensource.org/licenses/opengroup.php The Open Group Test Suite License
 */
App::import('Core', array('Object', 'Controller', 'Model'));

if (!class_exists('RequestActionController')) {
/**
 * RequestActionController class
 * 
 * @package              cake
 * @subpackage           cake.tests.cases.libs
 */
	class RequestActionController extends Controller {
/**
 * uses property
 * 
 * @var array
 * @access public
 */
		var $uses = array();
/**
 * test_request_action method
 * 
 * @access public
 * @return void
 */
		function test_request_action() {
			return 'This is a test';
		}
/**
 * another_ra_test method
 * 
 * @param mixed $id 
 * @param mixed $other 
 * @access public
 * @return void
 */
		function another_ra_test($id, $other) {
			return $id + $other;
		}
	}
}
/**
 * TestObject class
 * 
 * @package              cake
 * @subpackage           cake.tests.cases.libs
 */
class TestObject extends Object {
/**
 * firstName property
 * 
 * @var string 'Joel'
 * @access public
 */
	var $firstName = 'Joel';
/**
 * lastName property
 * 
 * @var string 'Moss'
 * @access public
 */
	var $lastName = 'Moss';
/**
 * methodCalls property
 * 
 * @var array
 * @access public
 */
	var $methodCalls = array();
/**
 * emptyMethod method
 * 
 * @access public
 * @return void
 */
	function emptyMethod() {
		$this->methodCalls[] = 'emptyMethod';
	}
/**
 * oneParamMethod method
 * 
 * @param mixed $param 
 * @access public
 * @return void
 */
	function oneParamMethod($param) {
		$this->methodCalls[] = array('oneParamMethod' => array($param));
	}
/**
 * twoParamMethod method
 * 
 * @param mixed $param 
 * @param mixed $param2 
 * @access public
 * @return void
 */
	function twoParamMethod($param, $param2) {
		$this->methodCalls[] = array('twoParamMethod' => array($param, $param2));
	}
/**
 * threeParamMethod method
 * 
 * @param mixed $param 
 * @param mixed $param2 
 * @param mixed $param3 
 * @access public
 * @return void
 */
	function threeParamMethod($param, $param2, $param3) {
		$this->methodCalls[] = array('threeParamMethod' => array($param, $param2, $param3));
	}
	/**
 * fourParamMethod method
 * 
 * @param mixed $param 
 * @param mixed $param2 
 * @param mixed $param3 
 * @param mixed $param4 
 * @access public
 * @return void
 */
	function fourParamMethod($param, $param2, $param3, $param4) {
		$this->methodCalls[] = array('fourParamMethod' => array($param, $param2, $param3, $param4));
	}
	/**
 * fiveParamMethod method
 * 
 * @param mixed $param 
 * @param mixed $param2 
 * @param mixed $param3 
 * @param mixed $param4 
 * @param mixed $param5 
 * @access public
 * @return void
 */
	function fiveParamMethod($param, $param2, $param3, $param4, $param5) {
		$this->methodCalls[] = array('fiveParamMethod' => array($param, $param2, $param3, $param4, $param5));
	}
/**
 * crazyMethod method
 * 
 * @param mixed $param 
 * @param mixed $param2 
 * @param mixed $param3 
 * @param mixed $param4 
 * @param mixed $param5 
 * @param mixed $param6 
 * @param mixed $param7 
 * @access public
 * @return void
 */
	function crazyMethod($param, $param2, $param3, $param4, $param5, $param6, $param7 = null) {
		$this->methodCalls[] = array('crazyMethod' => array($param, $param2, $param3, $param4, $param5, $param6, $param7));
	}
/**
 * methodWithOptionalParam method
 * 
 * @param mixed $param 
 * @access public
 * @return void
 */
	function methodWithOptionalParam($param = null) {
		$this->methodCalls[] = array('methodWithOptionalParam' => array($param));
	}
}


/**
 * Short description for class.
 *
 * @package    cake.tests
 * @subpackage cake.tests.cases.libs
 */
class ObjectTest extends UnitTestCase {
/**
 * setUp method
 * 
 * @access public
 * @return void
 */
	function setUp() {
		$this->object = new TestObject();
	}
/**
 * testLog method
 * 
 * @access public
 * @return void
 */
	function testLog() {
		@unlink(LOGS . 'error.log');
		$this->assertTrue($this->object->log('Test warning 1'));
		$this->assertTrue($this->object->log(array('Test' => 'warning 2')));
		$result = file(LOGS . 'error.log');
		$this->assertPattern('/^2[0-9]{3}-[0-9]+-[0-9]+ [0-9]+:[0-9]+:[0-9]+ Error: Test warning 1$/', $result[0]);
		$this->assertPattern('/^2[0-9]{3}-[0-9]+-[0-9]+ [0-9]+:[0-9]+:[0-9]+ Error: Array$/', $result[1]);
		$this->assertPattern('/^\($/', $result[2]);
		$this->assertPattern('/\[Test\] => warning 2$/', $result[3]);
		$this->assertPattern('/^\)$/', $result[4]);
		unlink(LOGS . 'error.log');

		@unlink(LOGS . 'error.log');
		$this->assertTrue($this->object->log('Test warning 1', LOG_WARNING));
		$this->assertTrue($this->object->log(array('Test' => 'warning 2'), LOG_WARNING));
		$result = file(LOGS . 'error.log');
		$this->assertPattern('/^2[0-9]{3}-[0-9]+-[0-9]+ [0-9]+:[0-9]+:[0-9]+ Warning: Test warning 1$/', $result[0]);
		$this->assertPattern('/^2[0-9]{3}-[0-9]+-[0-9]+ [0-9]+:[0-9]+:[0-9]+ Warning: Array$/', $result[1]);
		$this->assertPattern('/^\($/', $result[2]);
		$this->assertPattern('/\[Test\] => warning 2$/', $result[3]);
		$this->assertPattern('/^\)$/', $result[4]);
		unlink(LOGS . 'error.log');
	}
/**
 * testSet method
 * 
 * @access public
 * @return void
 */
	function testSet() {
		$this->object->_set('a string');
		$this->assertEqual($this->object->firstName, 'Joel');

		$this->object->_set(array('firstName'));
		$this->assertEqual($this->object->firstName, 'Joel');

		$this->object->_set(array('firstName' => 'Ashley'));
		$this->assertEqual($this->object->firstName, 'Ashley');

		$this->object->_set(array('firstName' => 'Joel', 'lastName' => 'Moose'));
		$this->assertEqual($this->object->firstName, 'Joel');
		$this->assertEqual($this->object->lastName, 'Moose');
	}
/**
 * testPersist method
 * 
 * @access public
 * @return void
 */
	function testPersist() {
		@unlink(CACHE . 'persistent' . DS . 'testmodel.php');

		$this->assertFalse($this->object->_persist('TestModel', null, $test));
		$this->assertFalse($this->object->_persist('TestModel', true, $test));
		$this->assertTrue($this->object->_persist('TestModel', null, $test));
		$this->assertTrue(file_exists(CACHE . 'persistent' . DS . 'testmodel.php'));
		$this->assertTrue($this->object->_persist('TestModel', true, $test));
		$this->assertNull($this->object->TestModel);

		@unlink(CACHE . 'persistent' . DS . 'testmodel.php');
	}
/**
 * testToString method
 * 
 * @access public
 * @return void
 */
	function testToString() {
		$result = strtolower($this->object->toString());
		$this->assertEqual($result, 'testobject');
	}
/**
 * testMethodDispatching method
 * 
 * @access public
 * @return void
 */
	function testMethodDispatching() {
		$this->object->emptyMethod();
		$expected = array('emptyMethod');
		$this->assertIdentical($this->object->methodCalls, $expected);

		$this->object->oneParamMethod('Hello');
		$expected[] = array('oneParamMethod' => array('Hello'));
		$this->assertIdentical($this->object->methodCalls, $expected);

		$this->object->twoParamMethod(true, false);
		$expected[] = array('twoParamMethod' => array(true, false));
		$this->assertIdentical($this->object->methodCalls, $expected);

		$this->object->threeParamMethod(true, false, null);
		$expected[] = array('threeParamMethod' => array(true, false, null));
		$this->assertIdentical($this->object->methodCalls, $expected);

		$this->object->crazyMethod(1, 2, 3, 4, 5, 6, 7);
		$expected[] = array('crazyMethod' => array(1, 2, 3, 4, 5, 6, 7));
		$this->assertIdentical($this->object->methodCalls, $expected);

		$this->object = new TestObject();
		$this->assertIdentical($this->object->methodCalls, array());

		$this->object->dispatchMethod('emptyMethod');
		$expected = array('emptyMethod');
		$this->assertIdentical($this->object->methodCalls, $expected);

		$this->object->dispatchMethod('oneParamMethod', array('Hello'));
		$expected[] = array('oneParamMethod' => array('Hello'));
		$this->assertIdentical($this->object->methodCalls, $expected);

		$this->object->dispatchMethod('twoParamMethod', array(true, false));
		$expected[] = array('twoParamMethod' => array(true, false));
		$this->assertIdentical($this->object->methodCalls, $expected);

		$this->object->dispatchMethod('threeParamMethod', array(true, false, null));
		$expected[] = array('threeParamMethod' => array(true, false, null));
		$this->assertIdentical($this->object->methodCalls, $expected);
		
		$this->object->dispatchMethod('fourParamMethod', array(1, 2, 3, 4));
		$expected[] = array('fourParamMethod' => array(1, 2, 3, 4));
		$this->assertIdentical($this->object->methodCalls, $expected);
		
		$this->object->dispatchMethod('fiveParamMethod', array(1, 2, 3, 4, 5));
		$expected[] = array('fiveParamMethod' => array(1, 2, 3, 4, 5));
		$this->assertIdentical($this->object->methodCalls, $expected);

		$this->object->dispatchMethod('crazyMethod', array(1, 2, 3, 4, 5, 6, 7));
		$expected[] = array('crazyMethod' => array(1, 2, 3, 4, 5, 6, 7));
		$this->assertIdentical($this->object->methodCalls, $expected);

		$this->object->dispatchMethod('methodWithOptionalParam', array('Hello'));
		$expected[] = array('methodWithOptionalParam' => array("Hello"));
		$this->assertIdentical($this->object->methodCalls, $expected);

		$this->object->dispatchMethod('methodWithOptionalParam');
		$expected[] = array('methodWithOptionalParam' => array(null));
		$this->assertIdentical($this->object->methodCalls, $expected);
	}
/**
 * testRequestAction method
 * 
 * @access public
 * @return void
 */
	function testRequestAction() {
		$result = $this->object->requestAction('');
		$this->assertFalse($result);
		
		$result = $this->object->requestAction('/request_action/test_request_action');
		$expected = 'This is a test';
		$this->assertEqual($result, $expected);

		$result = $this->object->requestAction(array('controller' => 'request_action', 'action' => 'test_request_action'));
		$expected = 'This is a test';
		$this->assertEqual($result, $expected);

		$result = $this->object->requestAction('/request_action/another_ra_test/2/5');
		$expected = 7;
		$this->assertEqual($result, $expected);

		$result = $this->object->requestAction(array('controller' => 'request_action', 'action' => 'another_ra_test'), array('pass' => array('5', '7')));
		$expected = 12;
		$this->assertEqual($result, $expected);

		Configure::write('controllerPaths', array(TEST_CAKE_CORE_INCLUDE_PATH . 'tests' . DS . 'test_app' . DS . 'controllers' . DS));
		Configure::write('viewPaths', array(TEST_CAKE_CORE_INCLUDE_PATH . 'tests' . DS . 'test_app' . DS . 'views' . DS));
		Configure::write('pluginPaths', array(TEST_CAKE_CORE_INCLUDE_PATH . 'tests' . DS . 'test_app' . DS . 'plugins' . DS));

		$result = $this->object->requestAction('/tests_apps/index', array('return'));
		$expected = 'This is the TestsAppsController index view';
		$this->assertEqual($result, $expected);

		$result = $this->object->requestAction(array('controller' => 'tests_apps', 'action' => 'index'), array('return'));
		$expected = 'This is the TestsAppsController index view';
		$this->assertEqual($result, $expected);

		$result = $this->object->requestAction('/tests_apps/some_method');
		$expected = 5;
		$this->assertEqual($result, $expected);

		$result = $this->object->requestAction(array('controller' => 'tests_apps', 'action' => 'some_method'));
		$expected = 5;
		$this->assertEqual($result, $expected);

		$result = $this->object->requestAction('/test_plugin/tests_plugins_tests/index', array('return'));
		$expected = 'This is the TestsPluginsTestsController index view';
		$this->assertEqual($result, $expected);

		$result = $this->object->requestAction('/test_plugin/tests_plugins_tests/index/some_param', array('return'));
		$expected = 'This is the TestsPluginsTestsController index view';
		$this->assertEqual($result, $expected);

		$result = $this->object->requestAction(array('controller' => 'tests_plugins_tests', 'action' => 'index', 'plugin' => 'test_plugin'), array('return'));
		$expected = 'This is the TestsPluginsTestsController index view';
		$this->assertEqual($result, $expected);

		$result = $this->object->requestAction('/test_plugin/tests_plugins_tests/some_method');
		$expected = 25;
		$this->assertEqual($result, $expected);

		$result = $this->object->requestAction(array('controller' => 'tests_plugins_tests', 'action' => 'some_method', 'plugin' => 'test_plugin'));
		$expected = 25;
		$this->assertEqual($result, $expected);
	}
/**
 * tearDown method
 * 
 * @access public
 * @return void
 */
	function tearDown() {
		unset($this->object);
	}
}
?>