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
 * Wrapper class for Image services.
 *
 * @author Fran Diéguez <fran@openhost.es>
 *
 * @version \$Id\$
 *
 * @copyright OpenHost S.L., Mér Xuñ 01 15:58:58 2011
 **/
namespace Panorama;

class Image
{
    /**
     * The instance of the object we will work into.
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
            throw new ArgumentException('We need a image url');
        }

        $serviceName = self::camelize(self::getDomain($url));

        // If the service starts with a number prepend a "c"
        // for avoid PHP language error
        if (preg_match("@^\d@", $serviceName)) {
            $serviceName = 'c'.$serviceName;
        }
        $className = "\Panorama\Image\\".$serviceName;

        // If the Video service is supported instantiate it,
        // otherwise raise Exception
        $classFile = dirname(__FILE__).DIRECTORY_SEPARATOR.'Image'
            .DIRECTORY_SEPARATOR.$serviceName.'.php';
        if (file_exists($file)) {
            $this->object = new $className($url, $options);
        } else {
            throw new \Exception('Image service or Url not supported');
        }
    }

    /**
     * Returns the given lower_case_and_underscored_word as a CamelCased word.
     *
     * @param string $lower_case_and_underscored_word Word to camelize
     *
     * @return string Camelized word. LikeThis.
     * @static
     *
     * @link http://book.cakephp.org/view/572/Class-methods
     */
    private function camelize($lowerCaseAndUnderscoredWord)
    {
        return str_replace(
            ' ',
            '',
            ucwords(str_replace('_', ' ', $lowerCaseAndUnderscoredWord))
        );
    }

    /*
     * Returns the domain string from url
     *
     * @param $url
     */
    private function getDomain($url = '')
    {
        $host = parse_url($url);
        $domainParts = preg_split("@\.@", $host['host']);

        // If domain name has a subdomain return the second part
        // if not return the first part
        $domainPartsCount = count($domainParts);

        return $domainParts[$domainPartsCount - 2];
    }
}
