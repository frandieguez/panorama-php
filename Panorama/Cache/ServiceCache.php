<?php
/**
 *  Copyright (C) 2011 by OpenHost S.L.
 *
 *  Permission is hereby granted, free of charge, to any person obtaining a copy
 *  of this software and associated documentation files (the "Software"), to deal
 *  in the Software without restriction, including without limitation the rights
 *  to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 *  copies of the Software, and to permit persons to whom the Software is
 *  furnished to do so, subject to the following conditions:
 *
 *  The above copyright notice and this permission notice shall be included in
 *  all copies or substantial portions of the Software.
 *
 *  THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 *  IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 *  FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 *  AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 *  LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 *  OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 *  THE SOFTWARE.
 **/
/**
 * Handles the cache 
 *
 * @package Panorama\Cache
 * @author Fran Diéguez <fran@openhost.es>
 **/

namespace Panorama\Cache;

class ServiceCache
{


    /**
    * Ensures that we always get one single instance
    *
    * @return object, the unique instance object 
    * @author Fran Dieguez <fran@openhsot.es>
    **/
    static public function getInstance($config)
    {

        if ((!self::$instance instanceof self) or
            (count(array_diff($this->config, $config)) > 0))
        { 
            self::$instance = new self($config); 
        } 
        return self::$instance;

    }
    
    
    /*
     * __construct()
     * @param $xmlFile, the XML file that contains information about an EP new
     */
    public function __construct($xmlFile) {
        
        return $this;
    
    }
    
    
    /*
     * Saves an item in cache
     * 
     * @param $name, the name of the value
     * @param $value, the value to save
     */
    static public function setAndReturn($name, $value)
    {
        apc_add($name, $value);
        return $value;
    }
    
    /*
     * Fetchs an item in cache if exists if not returns the default value
     * 
     * @param $key
     */
    static public function get($key="")
    {
        
        if (self::dataStoreAvailable()) {
            $value = apc_fetch($key);
            return $value;
        }
    
    }
    
    /*
     * Check if a value is into data store
     * 
     * @param $key
     */
    static public function exists($key="")
    {
        if (self::dataStoreAvailable()) {
            
            return apc_exists($key);
        
        } else {
            return false;
        }
    }
    
    
    
    
    /*
     * Check if APC is available
     * 
     */
    static public function dataStoreAvailable()
    {
        return function_exists('apc_exists');
    }
    
} // END class
