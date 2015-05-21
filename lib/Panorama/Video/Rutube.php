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
 * Wrapper class for Rutube videos.
 *
 * @author Fran Diéguez <fran@openhost.es>
 *
 * @version \$Id\$
 *
 * @copyright OpenHost S.L., Mér Xuñ 01 15:58:58 2011
 **/
namespace Panorama\Video;

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
        //rt_info["movie"][0]["title"][0].strip
        if (!isset($this->title)) {
            $rtInfo = $this->getRtInfo();
            $this->title = trim((string) $rtInfo->movie[0]->title);
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
            $size = 2;
            $movieHash = $this->getMovieHash();
            $sub1 = substr($movieHash, 0, 2);
            $sub2 = substr($movieHash, 2, 2);
            $this->thumbnail = "http://img.rutube.ru/thumbs/{$sub1}/{$sub2}/{$movieHash}-{$size}.jpg";
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
        $movieHash = $this->getMovieHash();

        return "http://video.rutube.ru/{$movieHash}";
    }

    /*
     * Returns the movie hash to make request to Rutube
     *
     */
    public function getMovieHash()
    {
        if (!isset($this->movieHash)) {
            $rtInfo = $this->getRtInfo();
            preg_match('@[a-f0-9]+$@', $rtInfo->movie->playerLink[0], $matches);
            $this->movieHash = $matches[0];
        }

        return $this->movieHash;
    }

    /*
     * Returns the HTML object to embed for this Rutube video
     *
     */
    public function getEmbedHTML($options = [])
    {
        $defaultOptions = ['width' => 560, 'height' => 349];
        $options = array_merge($defaultOptions, $options);

        // convert options into
        $htmlOptions = '';
        if (count($options) > 0) {
            foreach ($options as $key => $value) {
                if (in_array($key, ['width', 'height'])) {
                    continue;
                }
                $htmlOptions .= '&'.$key.'='.$value;
            }
        }

        return  "<object width='{$options['width']}' "
            ."height='{$options['height']}'>\n"
            ."<param name='movie' value='{$this->getEmbedUrl()}'></param>\n"
            ."<param name='wmode' value='window'></param>\n"
            ."<param name='allowFullScreen' value='true'></param>\n"
            ."<embed type='application/x-shockwave-flash\n"
            ."src='{$this->getEmbedUrl()}'\n"
            ."width='{$options['width']}' "
            ."height='{$options['height']}'\n"
            ."wmode='window' allowFullScreen='true'></embed>\n"
            .'</object>';
    }

    /*
     * Returns the FLV url for this Rutube video
     *
     */
    public function getFLV()
    {
        $movieHash = $this->getMovieHash();

        return "http://bl.rutube.ru/{$movieHash}.iflv";
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
        $videoId = (string) $this->getVideoId();
        $url = $this->rtXmlAPIUrl."{$videoId}";

        if (!isset($this->rtInfo)) {
            $content = file_get_contents($url);
            $this->rtInfo = simplexml_load_string($content);
        }

        return $this->rtInfo;
    }

    /*
     * Calculates the Video ID from an Rutube URL
     *
     * @param $url
     */
    public function getVideoID()
    {
        if (!isset($this->videoId)) {
            $path = parse_url($this->url, PHP_URL_PATH);
            preg_match("@(\d+)@", $path, $matches);
            $this->videoId = (int) $matches[1];
        }

        return $this->videoId;
    }
}
