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
 * Wrapper class for Image services
 *
 * @author Fran Diéguez <fran@openhost.es>
 * @version \$Id\$
 * @copyright OpenHost S.L., Mér Xuñ 01 15:58:58 2011
 * @package Panorama
 **/
namespace Panorama;

class Image
{
    /**
     * The instance of the object we will work into
     */
    private $object = null;

    /*
     * __construct()
     * @param $arg
     */
    public function __construct($url = null, $options = null)
    {
        // if nothing is passed in instantiation raise an argument error.
        if (!isset($url) || is_null($url)) {
            throw new ArgumentException("We need a image url");
        }

        $serviceName = self::camelize(self::getDomain($url));

        // If the service starts with a number prepend a "c" for avoid PHP language error
        if (preg_match("@^\d@",$serviceName)) { $serviceName = "c".$serviceName; }
        $className = "\Panorama\Image\\" . $serviceName;

        // If the Video service is supported instantiate it, otherwise raise Exception
        if (file_exists(dirname(__FILE__).DIRECTORY_SEPARATOR."Video".DIRECTORY_SEPARATOR.$serviceName.".php")) {
            $this->object = new $className($url, $options);
        } else {
            throw new \Exception("Video service or Url not supported");
        }

    }

    /**
    * Returns the given lower_case_and_underscored_word as a CamelCased word.
    *
    * @param string $lower_case_and_underscored_word Word to camelize
    * @return string Camelized word. LikeThis.
    * @access public
    * @static
    * @link http://book.cakephp.org/view/572/Class-methods
    */
    private function camelize($lowerCaseAndUnderscoredWord)
    {
        return str_replace(" ", "", ucwords(str_replace("_", " ", $lowerCaseAndUnderscoredWord)));
    }

    /*
     * Returns the domain string from url
     *
     * @param $url
     */
    private function getDomain($url="")
    {
        $host = parse_url($url);
        $domainParts = preg_split("@\.@",$host["host"]);

        /**
         * If domain name has a subdomain return the second part
         * if not return the first part
        */
        $domainPartsCount = count($domainParts);

        return $domainParts[$domainPartsCount - 2];

    }

}
