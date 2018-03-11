<?php
/**
 * This file is part of the Panorama package.
 *
 * (c)  Fran Dieguez <fran.dieguez@mabishu.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 **/
namespace Panorama\Video;

/**
 * Wrapper class for Rutube videos.
 **/
class Rutube implements VideoInterface
{
    public $url;
    public $params = [];

    private $rtXmlAPIUrl = 'http://rutube.ru/api/video/';

    /**
     * @param $url
     * @param array $options
     */
    public function __construct($url, $params = [])
    {
        $this->url = $url;
        $this->params = $params;
    }

    /*
     * Returns the title for this Rutube video
     *
     */
    public function getTitle()
    {
        if (!isset($this->title)) {
            $rtInfo = $this->getRtInfo();

            $this->title = trim($rtInfo->title);
        }

        return $this->title;
    }

    /*
     * Returns the thumbnail for this Rutube video
     *
     */
    public function getThumbnail()
    {
        if (!isset($this->thumbnail)) {
            $rtInfo = $this->getRtInfo();

            $this->thumbnail = trim($rtInfo->thumbnail_url);
        }

        return $this->thumbnail;
    }

    /*
     * Returns the duration in secs for this Rutube video
     *
     */
    public function getDuration()
    {
        return;
    }

    /*
     * Returns the embed url for this Rutube video
     *
     */
    public function getEmbedUrl()
    {
        // //rutube.ru/play/embed/4436308
        if (!isset($this->embed_url)) {
            $rtInfo = $this->getRtInfo();

            $matched = preg_match('@src="([^""]*)"@', $rtInfo->html, $matches);

            $this->embed_url = $matches[1];
        }

        return $this->embed_url;
    }

    /*
     * Returns the HTML object to embed for this Rutube video
     *
     */
    public function getEmbedHTML($options = [])
    {
        $defaultOptions = ['width' => 560, 'height' => 349];
        $options = array_merge($defaultOptions, $options);

        $this->embed_html = sprintf(
            '<iframe width="' . $options['width'] . '" height="' . $options['height'] . '" '
            . 'src="' . $this->getEmbedUrl() . '" '
            . 'frameborder="0" webkitAllowFullScreen mozallowfullscreen allowfullscreen></iframe>'
        );

        return $this->embed_html;
    }

    /*
     * Returns the FLV url for this Rutube video
     *
     */
    public function getFLV()
    {
        return;
    }

    /*
     * Returns the Download url for this Rutube video
     *
     */
    public function getDownloadUrl()
    {
        return;
    }

    /*
     * Returns the name of the Video service
     *
     */
    public function getService()
    {
        return 'Rutube';
    }

    /*
     * Loads the video information from Rutube API
     *
     */
    public function getRtInfo()
    {
        if (isset($this->rtInfo)) {
            return $this->rtInfo;
        }

        $this->rtInfo = json_decode(
            file_get_contents('https://rutube.ru/api/oembed/?format=json&url='.$this->url)
        );

        return $this->rtInfo;
    }

    /*
     * Calculates the Video ID from an Rutube URL
     *
     * @param $url
     */
    public function getVideoID()
    {
        if (isset($this->videoId)) {
            return $this->videoId;
        }

        $matched = preg_match('@/video/([a-z0-9])*@', $this->url, $matches);
        if ($matched) {
            $this->videoId = $matches[1];
        }

        $matched = preg_match('@([a-z0-9])*@', $this->url, $matches);
        if ($matched) {
            $this->videoId = $matches[1];
        }

        return $this->videoId;
    }
}
