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
 * Wrapper class for MySpace videos.
 *
 * @author Fran Diéguez <fran@openhost.es>
 *
 * @version \$Id\$
 *
 * @copyright OpenHost S.L., Mér Xuñ 01 15:58:58 2011
 **/
namespace Panorama\Video;

class Myspace implements VideoInterface
{
    public $url;
    public $params = [];

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
     * Returns the page content for this video
     *
     * @param $arg
     */
    public function getPage()
    {
        if (!isset($this->page)) {
            $videoId = $this->getVideoID();
            $content = file_get_contents(
                "http://mediaservices.myspace.com/services/rss.ashx?type=video&videoID={$videoId}"
            );
            $this->page = simplexml_load_string($content);
        }

        return $this->page;
    }

    /*
     * Returns the title for this MySpace video
     *
     */
    public function getTitle()
    {
        if (!isset($this->title)) {
            $titles = $this->getPage()->xpath('//item/title');
            $this->title = (string) $titles[0];
        }

        return $this->title;
    }

    /*
     * Returns the thumbnail for this MySpace video
     *
     */
    public function getThumbnail()
    {
        if (!isset($this->thumbnail)) {
            $thumbnails = $this->getPage()->xpath('//item/media:thumbnail');
            $this->thumbnail = (string) $thumbnails[0]['url'];
        }

        return $this->thumbnail;
    }

    /*
     * Returns the duration in secs for this MySpace video
     *
     */
    public function getDuration()
    {
        return;
    }

    /*
     * Returns the embed url for this MySpace video
     *
     */
    public function getEmbedUrl()
    {
        if (!isset($this->embedUrl)) {
            $item = $this->getPage()->xpath('//myspace:itemID');
            $itemID = (string) $item[0];
            $this->embedUrl = "http://lads.myspace.com/videos/vplayer.swf?m={$itemID}&v=2&type=video";
        }

        return $this->embedUrl;
    }

    /*
     * Returns the HTML object to embed for this MySpace video
     *
     */
    public function getEmbedHTML($options = [])
    {
        if (!isset($this->embedHTML)) {
            $defaultOptions = ['width' => 560, 'height' => 349];
            $options = array_merge($defaultOptions, $options);

            // convert options into
            $htmlOptions = '';
            if (count($options) > 0) {
                foreach ($options as $key => $value) {
                    if (in_array($key, array('width', 'height'))) {
                        continue;
                    }
                    $htmlOptions .= '&'.$key.'='.$value;
                }
            }

            $this->embedHTML =
                "<embed src='{$this->getEmbedUrl()}'\n"
                ."width='{$options['width']}' "
                ."height='{$options['height']}'\n"
                ."type='application/x-shockwave-flash'>\n"
                .'</embed>';
        }

        return $this->embedHTML;
    }

    /*
     * Returns the FLV url for this MySpace video
     *
     */
    public function getFLV()
    {
        if (!isset($this->FLV)) {
            $item = $this->getPage()->xpath('//media:content');
            $this->FLV = (string) $item[0]['url'];
        }

        return $this->FLV;
    }

    /*
     * Returns the Download url for this MySpace video
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
        return 'Myspace';
    }

    /*
     * Calculates the Video ID from an MySpace URL
     *
     * @param $url
     */
    public function getVideoID()
    {
        if (!isset($this->videoId)) {
            preg_match("@videoid=(\w*)@", $this->url, $matches);
            if (count($matches) > 0) {
                $this->videoId = $matches[1];
            } else {
                preg_match("@VideoID=(\w*)@", $this->url, $matches);
                $this->videoId = $matches[1];
            }
        }

        return $this->videoId;
    }
}
