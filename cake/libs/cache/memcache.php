<?php
/* SVN FILE: $Id: memcache.php 7089 2008-06-02 17:35:56Z gwoo $ */
/**
 * Memcache storage engine for cache
 *
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) :  Rapid Development Framework <http://www.cakephp.org/>
 * Copyright 2005-2008, Cake Software Foundation, Inc.
 *								1785 E. Sahara Avenue, Suite 490-204
 *								Las Vegas, Nevada 89104
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright		Copyright 2005-2008, Cake Software Foundation, Inc.
 * @link				http://www.cakefoundation.org/projects/info/cakephp CakePHP(tm) Project
 * @package			cake
 * @subpackage		cake.cake.libs.cache
 * @since			CakePHP(tm) v 1.2.0.4933
 * @version			$Revision: 7089 $
 * @modifiedby		$LastChangedBy: gwoo $
 * @lastmodified	$Date: 2008-06-02 12:35:56 -0500 (Mon, 02 Jun 2008) $
 * @license			http://www.opensource.org/licenses/mit-license.php The MIT License
 */
/**
 * Memcache storage engine for cache
 *
 * @package		cake
 * @subpackage	cake.cake.libs.cache
 */
class MemcacheEngine extends CacheEngine {
/**
 * Memcache wrapper.
 *
 * @var object
 * @access private
 */
	var $__Memcache = null;
/**
 * settings
 * 		servers = string or array of memcache servers, default => 127.0.0.1
 * 		compress = boolean, default => false
 *
 * @var array
 * @access public
 */
	var $settings = array();
/**
 * Initialize the Cache Engine
 *
 * Called automatically by the cache frontend
 * To reinitialize the settings call Cache::engine('EngineName', [optional] settings = array());
 *
 * @param array $setting array of setting for the engine
 * @return boolean True if the engine has been successfully initialized, false if not
 * @access public
 */
	function init($settings = array()) {
		if (!class_exists('Memcache')) {
			return false;
		}
		parent::init(array_merge(array(
			'engine'=> 'Memcache', 'prefix' => Inflector::slug(APP_DIR) . '_', 'servers' => array('127.0.0.1'), 'compress'=> false
			), $settings)
		);

		if ($this->settings['compress']) {
			$this->settings['compress'] = MEMCACHE_COMPRESSED;
		}
		if (!is_array($this->settings['servers'])) {
			$this->settings['servers'] = array($this->settings['servers']);
		}

		$this->__Memcache =& new Memcache();
		foreach ($this->settings['servers'] as $server) {
			$parts = explode(':', $server);
			$host = $parts[0];
			$port = 11211;
			if (isset($parts[1])) {
				$port = $parts[1];
			}
			if ($this->__Memcache->addServer($host, $port)) {
				if ($this->__Memcache->connect($host, $port)) {
					return true;
				}
			}
		}
		return false;
	}
/**
 * Write data for key into cache
 *
 * @param string $key Identifier for the data
 * @param mixed $value Data to be cached
 * @param integer $duration How long to cache the data, in seconds
 * @return boolean True if the data was succesfully cached, false on failure
 * @access public
 */
	function write($key, &$value, $duration) {
		return $this->__Memcache->set($key, $value, $this->settings['compress'], $duration);
	}
/**
 * Read a key from the cache
 *
 * @param string $key Identifier for the data
 * @return mixed The cached data, or false if the data doesn't exist, has expired, or if there was an error fetching it
 * @access public
 */
	function read($key) {
		return $this->__Memcache->get($key);
	}
/**
 * Delete a key from the cache
 *
 * @param string $key Identifier for the data
 * @return boolean True if the value was succesfully deleted, false if it didn't exist or couldn't be removed
 * @access public
 */
	function delete($key) {
		return $this->__Memcache->delete($key);
	}
/**
 * Delete all keys from the cache
 *
 * @return boolean True if the cache was succesfully cleared, false otherwise
 * @access public
 */
	function clear() {
		return $this->__Memcache->flush();
	}
/**
 * Connects to a server in connection pool
 *
 * @param string $host host ip address or name
 * @param integer $port Server port
 * @return boolean True if memcache server was connected
 * @access public
 */
	function connect($host, $port = 11211) {
		if ($this->__Memcache->getServerStatus($host, $port) === 0) {
			if ($this->__Memcache->connect($host, $port)) {
				return true;
			}
			return false;
		}
		return true;
	}
}
?>