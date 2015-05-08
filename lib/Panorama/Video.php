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
 * Wrapper class
 *
 * @author Fran Diéguez <fran@openhost.es>
 * @version \$Id\$
 * @copyright OpenHost S.L., Mér Xuñ 01 15:58:58 2011
 * @package Panorama
 **/

namespace Panorama;


class Video
{
    /**
     * The instance of the object we will work into
     */
    private $object = null;

    private $className = null;

    /*
     * __construct()
     * @param $arg
     */
    public function __construct($url = null, $params = [])
    {
        // check arguments validation
        if (!isset($url) || is_null($url)) {
            throw new \InvalidArgumentException("We need a video url");
        }

        $this->url = $url;

        $serviceName = self::camelize(self::getDomain($url));

        // If the service starts with a number prepend a "c" for avoid PHP language error
        if (preg_match("@^\d@", $serviceName)) {
            $serviceName = "c" . $serviceName;
        }
        $this->className = "\Panorama\Video\\" . $serviceName;

        // If the Video service is supported instantiate it, otherwise raise Exception
        if (file_exists(dirname(__FILE__) . DIRECTORY_SEPARATOR . "Video" . DIRECTORY_SEPARATOR . $serviceName . ".php")) {
            $this->object = new $this->className($url, $params);
            if (!($this->object instanceof \Panorama\Video\VideoInterface)) {
                throw new \Exception("Video ID not valid.");
            }
        } else {
            throw new \Exception("Video service or Url not supported");
        }
    }

    /*
     * Returns the sercice object to operate directly with with
     *
     */
    public function getObject()
    {
        return $this->object;
    }

    /*
     * Returns the video title for the instantiated object.
     *
     * @returns string, the title of the video
     */
    public function getTitle()
    {

        return $this->object->getTitle();

    }

    /*
     * Returns the video thumbnail url for the instantiated object.
     *
     * @returns string, the thumbnail url of the video
     */
    public function getThumbnail()
    {
        return $this->object->getThumbnail();
    }

    /*
     * Returns the video duration for the instantiated object.
     *
     * @returns int, the duration of the video
     */
    public function getDuration()
    {
        return $this->object->getDuration();
    }

    /*
     * Returns the video embed url for the instantiated object.
     *
     * @returns string, the embed of the video
     */
    public function getEmbedUrl()
    {
        return $this->object->getEmbedUrl();
    }

    /*
     * Returns the video irfor the instantiated object.
     *
     * @returns string, the id of the video
     */
    public function getVideoID()
    {
        return $this->object->getVideoID();
    }

    /*
     * Returns the video embed url for the instantiated object.
     *
     * @returns string, the embed of the video
     */
    public function getEmbedHTML($options)
    {
        return $this->object->getEmbedHTML($options);
    }

    /*
     * Returns the video embed url for the instantiated object.
     *
     * @returns string, the embed of the video
     */
    public function getFLV()
    {
        return $this->object->getFLV();
    }

    /*
     * Returns the video embed url for the instantiated object.
     *
     * @returns string, the embed of the video
     */
    public function getDownloadUrl()
    {
        return $this->object->getDownloadUrl();
    }

    /*
     * Returns the video embed url for the instantiated object.
     *
     * @returns string, the embed of the video
     */
    public function getService()
    {
        return $this->object->getService();
    }

    /*
     * Returns the video embed url for the instantiated object.
     *
     * @returns string, the embed of the video
     */
    public function getVideoDetails($width = 425, $height = 344)
    {

        return array(
            "title"       => (string) $this->object->getTitle(),
            "thumbnail"   => (string) $this->object->getThumbnail(),
            "embedUrl"    => (string) $this->object->getEmbedUrl(),
            "embedHTML"   => (string) $this->object->getEmbedHTML(),
            "FLV"         => (string) $this->object->getFLV(),
            "downloadUrl" => (string) $this->object->getDownloadUrl(),
            "service"     => (string) $this->object->getService(),
            "duration"    => (string) $this->object->getDuration(),
         );

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
    public function camelize($lowerCaseAndUnderscoredWord)
    {
        return str_replace(" ", "", ucwords(str_replace("_", " ", $lowerCaseAndUnderscoredWord)));
    }

    /*
     * Returns the domain string from url
     *
     * @param $url
     */
    public static function getDomain($url = "")
    {
        $host = parse_url($url);
        $domainParts = preg_split("@\.@", $host["host"]);

        /**
         * If domain name has a subdomain return the second part
         * if not return the first part
         */
        $domainPartsCount = count($domainParts);

        return $domainParts[$domainPartsCount - 2];
    }
}
