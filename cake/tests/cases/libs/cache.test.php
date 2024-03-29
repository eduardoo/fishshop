<?php
/* SVN FILE: $Id: cache.test.php 7295 2008-06-27 08:17:02Z gwoo $ */
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
if (!class_exists('Cache')) {
	require LIBS . 'cache.php';
}
/**
 * Short description for class.
 *
 * @package    cake.tests
 * @subpackage cake.tests.cases.libs
 */
class CacheTest extends CakeTestCase {
/**
 * start method
 *
 * @access public
 * @return void
 */
	function start() {
		$this->config = Cache::config('default');
		$settings = Cache::config('default', array('engine'=> 'File', 'path' => CACHE));
	}
/**
 * end method
 *
 * @access public
 * @return void
 */
	function end() {
		Cache::config('default', $this->config['settings']);
	}
/**
 * testConfig method
 *
 * @access public
 * @return void
 */
	function testConfig() {
		$settings = array('engine' => 'File', 'path' => TMP . 'tests', 'prefix' => 'cake_test_');
		$results = Cache::config('new', $settings);
		$this->assertEqual($results, Cache::config('new'));
	}
/**
 * testConfigChange method
 *
 * @access public
 * @return void
 */
	function testConfigChange() {
		$result = Cache::config('sessions', array('engine'=> 'File', 'path' => TMP . 'sessions'));
		$this->assertEqual($result['settings'], Cache::settings('File'));

		$result = Cache::config('tests', array('engine'=> 'File', 'path' => TMP . 'tests'));
		$this->assertEqual($result['settings'], Cache::settings('File'));
	}
/**
 * testWritingWithConfig method
 *
 * @access public
 * @return void
 */
	function testWritingWithConfig() {

		Cache::config('sessions');

		Cache::write('test_somthing', 'this is the test data', 'tests');

		$expected = array(
			'path' => TMP . 'sessions',
			'prefix' => 'cake_',
			'lock' => false,
			'serialize' => true,
			'duration' => 3600,
			'probability' => 100,
			'engine' => 'File',
		);
		$this->assertEqual($expected, Cache::settings('File'));
	}
/**
 * testInitSettings method
 *
 * @access public
 * @return void
 */
	function testInitSettings() {
		Cache::engine('File', array('path' => TMP . 'tests'));
		$settings = Cache::settings();
		$expecting = array(
			'engine' => 'File',
			'duration'=> 3600,
			'probability' => 100,
			'path'=> TMP . 'tests',
			'prefix'=> 'cake_',
			'lock' => false,
			'serialize'=> true
		);
		$this->assertEqual($settings, $expecting);
	}
/**
 * testWriteEmptyValues method
 * 
 * @access public
 * @return void
 */
	function testWriteEmptyValues() {
		return;
		Cache::engine('File', array('path' => TMP . 'tests'));
		Cache::write('App.falseTest', false);
		$this->assertIdentical(Cache::read('App.falseTest'), false);

		Cache::write('App.trueTest', true);
		$this->assertIdentical(Cache::read('App.trueTest'), true);

		Cache::write('App.nullTest', null);
		$this->assertIdentical(Cache::read('App.nullTest'), null);

		Cache::write('App.zeroTest', 0);
		$this->assertIdentical(Cache::read('App.zeroTest'), 0);

		Cache::write('App.zeroTest2', '0');
		$this->assertIdentical(Cache::read('App.zeroTest2'), '0');
	}
}
?>