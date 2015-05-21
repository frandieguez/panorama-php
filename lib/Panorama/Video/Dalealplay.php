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
 * Wrapper class for Dalealplay videos.
 *
 * @author Fran Diéguez <fran@openhost.es>
 *
 * @version \$Id\$
 *
 * @copyright OpenHost S.L., Mér Xuñ 01 15:58:58 2011
 **/
namespace Panorama\Video;

class Dalealplay implements VideoInterface
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

        $this->getVideoID();
    }

    /*
     * Fetchs the contents of the DaleAlPlay video page
     *
     */
    public function getPage()
    {
        if (!isset($this->page)) {
            $this->page = file_get_contents($this->url);
        }

        return $this->page;
    }

    /*
     * Sets the page contents, useful for using mocking objects
     *
     * @param $arg
     */
    public function setPage($page = '')
    {
        if (!empty($page)
            && !isset($this->page)
        ) {
            $this->page = $page;
        }

        return $this->page;
    }

    /*
     * Returns the title for this Dalealplay video
     *
     */
    public function getTitle()
    {
        if (!isset($this->title)) {
            preg_match('@<title>(.*)</title>@', $this->getPage(), $matches);
            $title = preg_split('@ - www.dalealplay.com@', $matches[1]);
            $title = $title[0];
            $this->title = iconv('ISO-8859-1', 'UTF-8', (string) $title);
        }

        return $this->title;
    }

    /*
     * Returns the thumbnail for this Dalealplay video
     *
     */
    public function getThumbnail()
    {
        if (!isset($this->thumbnail)) {
            $videoId = $this->getVideoId();
            $this->thumbnail = "http://thumbs.dalealplay.com/img/dap/{$videoId}/thumb";
        }

        return $this->thumbnail;
    }

    /*
     * Returns the duration in secs for this Dalealplay video
     *
     */
    public function getDuration()
    {
        return;
    }

    /*
     * Returns the embed url for this Dalealplay video
     *
     */
    public function getEmbedUrl()
    {
        //@page.search("//link[@rel='video_src']").first.attributes["href"].sub("autoStart=true", "autoStart=false")
        if (!isset($this->embedUrl)) {
            preg_match('@rel="video_src"\shref="(.*)"@', $this->getPage(), $matches);
            $title = preg_replace('@autoStart=true@', 'autoStart=false', $matches[1]);
            $this->embedUrl = (string) $title;
        }

        return $this->embedUrl;
    }

    /*
     * Returns the HTML object to embed for this Dalealplay video
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

        return "<object type='application/x-shockwave-flash'\n"
            ."width='{$options['width']}' height='{$options['height']}'\n"
            ."data='{$this->getEmbedUrl()}'>\n"
            ."<param name='quality' value='best' />\n"
            ."<param name='allowfullscreen' value='true' />\n"
            ."<param name='movie' value='{$this->getEmbedUrl()}' />\n"
            .'</object>';
    }

    /*
     * Returns the FLV url for this Dalealplay video
     *
     */
    public function getFLV()
    {
        //"http://videos.dalealplay.com/contenidos3/#{CGI::parse(URI::parse(embed_url).query)['file']}"
        if (!isset($this->FLV)) {
            $this->FLV = '';
        }

        return $this->FLV;
    }

    /*
     * Returns the Download url for this Dalealplay video
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
        return 'Dalealplay';
    }

    /*
     * Calculates the Video ID from an Dalealplay URL
     *
     * @param $url
     */
    public function getVideoId()
    {
        if (!isset($this->videoId)) {
            $path = parse_url($this->url, PHP_URL_QUERY);
            preg_match("@con=(\w*)@", $path, $matches);
            $this->videoId = $matches[1];
        }

        return $this->videoId;
    }
}
