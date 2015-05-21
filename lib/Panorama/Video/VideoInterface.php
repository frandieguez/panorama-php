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
 * Definition of the API for all the video resource clases.
 *
 * @author Fran Diéguez <fran@openhost.es>
 *
 * @version \$Id\$
 *
 * @copyright OpenHost S.L., Mér Xuñ 01 15:58:58 2011
 **/
namespace Panorama\Video;

/**
 * Interface to define the API for all the video resource clases.
 *
 * @author Fran Diéguez
 **/
interface VideoInterface
{
    /**
     * Initializes the class with an url and required params.
     */
    public function __construct($url, $params = []);

    /**
     * Returns the download url for the video.
     */
    public function getDownloadUrl();

    /**
     * Returns the video duration in secs.
     */
    public function getDuration();

    /**
     * Returns the video embedHTML for put in a webpage.
     */
    public function getEmbedHTML();

    /**
     * Returns the url of the video for embed in custom flash player.
     */
    public function getEmbedUrl();

    /**
     * Returns the url of the video in FLV format.
     */
    public function getFLV();

    /**
     * Returns the service name of the video.
     */
    public function getService();

    /**
     * Returns the default thumbnail of this video.
     */
    public function getThumbnail();

    /**
     * Returns the title of this video.
     */
    public function getTitle();

    /**
     * Returns the internal video id in the particular service.
     */
    public function getVideoId();
}
