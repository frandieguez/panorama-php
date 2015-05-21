<?php

/**
 * This file is part of the Onm package.
 *
 * (c)  OpenHost S.L. <developers@openhost.es>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 **/
/**
 * Class that allows to store key-value pairs in cache.
 *
 * @author Fran Diéguez <fran@openhost.es>
 **/
namespace Panorama\Cache;

/**
 * Class that allows to store key-value pairs in cache.
 */
class ServiceCache
{
    /**
     * Ensures that we always get one single instance.
     *
     * @return object the unique instance object
     *
     * @author Fran Dieguez <fran@openhsot.es>
     **/
    public static function getInstance($config)
    {
        if ((!self::$instance instanceof self) ||
            count(array_diff($this->config, $config)) > 0
        ) {
            self::$instance = new self($config);
        }

        return self::$instance;
    }

    /*
    * __construct()
    * @param $xmlFile the XML file that contains information about an EP new
    */
    public function __construct($xmlFile)
    {
        return $this;
    }

    /*
    * Saves an item in cache
    *
    * @param $name the name of the value
    * @param $value the value to save
    */
    public static function setAndReturn($name, $value)
    {
        apc_add($name, $value);

        return $value;
    }

    /*
    * Fetchs an item in cache if exists if not returns the default value
    *
    * @param string $key the name of the key we want to fetch
    */
    public static function get($key = '')
    {
        if (self::dataStoreAvailable()) {
            $value = apc_fetch($key);

            return $value;
        }
    }

    /*
    * Check if a value is into data store
    * @param $key
    */
    public static function exists($key = '')
    {
        if (self::dataStoreAvailable()) {
            return apc_exists($key);
        } else {
            return false;
        }
    }

    /*
    * Check if APC is available
    * @return boolean true if is present
    */
    public static function dataStoreAvailable()
    {
        return function_exists('apc_exists');
    }
} // END class
