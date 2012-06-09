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
 * Wrapper class for MTVhive videos
 *
 * @author Fran Diéguez <fran@openhost.es>
 * @version \$Id\$
 * @copyright OpenHost S.L., Mér Xuñ 01 15:58:58 2011
 * @package Panorama\Video
 **/
namespace Panorama\Video;

class Mtvhive
{
    /*
     * __construct()
     * @param $url
     */
    public function __construct($url, $options = null)
    {

        throw new \Exception("Not implemented");

        $this->url = $url;
        $this->videoId = $this->getVideoID();
        $this->title = $this->getTitle();
        $searchTerm = preg_replace( array("@\s@", "@'@"), array("%20", ""), $this->title);

        $contents = file_get_contents("http://api.mtvnservices.com/1/video/search/?term=" . $searchTerm);
        var_dump($contents);
        die();

        //res =  Net::HTTP.get(URI.parse("http://api.mtvnservices.com/1/video/search/?term=#{searchterms[0].gsub(' ', '%20')}"))

        //$this->thumbnail = $this->getThumbnail();
        //$this->duration = $this->getDuration();
        //$this->embedUrl = $this->getEmbedUrl();
        //$this->embedHTML = $this->getEmbedHTML();
        //$this->FLV = $this->getFLV();
        //$this->downloadUrl = $this->getEmbedUrl();
        //$this->service = $this->getService();

    }

    /*
     * Fetchs the web page for the video
     *
     * Function used as wrapper for the rest of the function
     */
    private function getDocumentPage()
    {
        if (!isset($this->document)) {
            $this->document = file_get_contents($this->url);
        }

        return $this->document;
    }

    /*
     * Calculates the Video ID from an Mtvmusic URL
     *
     * @param $url
     */
    public function getVideoID()
    {

        if (!isset($this->videoId)) {

            preg_match('@v=([\w]*)&?@', $this->url, $matches);

            if (count($matches) < 1) {
                $split = preg_split('@/@', $this->url);
                $this->videoId = $split[6];
            } else {
                $this->videoId = $matches[1];
            }

        }

        return $this->videoId;

    }

    /*
     * Returns the title for this Mtvmusic video
     *
     */
    public function getTitle()
    {

        if (!isset($this->title)) {

            preg_match('@<title>(.*)</title>@', $this->getDocumentPage(), $matches);
            if (!count($matches) < 1) {
                $title = trim($matches[1]);
                $title = preg_split("@\s-\sWatch\sFree\sMusic\sVideos\sOnline\s\|\sMTV\sHive@", $title);
                $this->title = $title[0];
            } else {
                $this->title = "";
            }
        }

        return $this->title;

    }

    /*
     * Returns the thumbnail for this Mtvmusic video
     *
     */
    public function getThumbnail()
    {

        if (!isset($this->thumbnail)) {
            preg_match('@url\s*:\s*\'(.*)\',@', $this->getDocumentPage(), $matches);
            var_dump($matches);
            die();

            if (count($matches) > 0) {
                $this->thumbnail = $matches[1];
            } else {
                $this->thumbnail = null;
            }
        }

        return $this->thumbnail;

    }

    /*
     * Returns the duration in secs for this Mtvmusic video
     *
     */
    public function getDuration()
    {
        return null;
    }

    /*
     * Returns the embed url for this Mtvmusic video
     *
     */
    public function getEmbedUrl()
    {
        if (!isset($this->embedUrl)) {
            return 'http://media.mtvnservices.com/mgid:uma:video:mtvmusic.com:{$this->getVideoId()}';
        }

        return $this->embedUrl;
    }

    /*
     * Returns the HTML object to embed for this Mtvmusic video
     *
     */
    public function getEmbedHTML($options = array())
    {

        if (!isset($this->embedHTML)) {
            $defaultOptions = array(
                  'width' => 560,
                  'height' => 349
                  );

            $options = array_merge($defaultOptions, $options);
            unset($options['width']);
            unset($options['height']);

            // convert options into and url encoded vars
            $htmlOptions = '';
            if (count($options) > 0) {
                foreach ($options as $key => $value) {
                    $htmlOptions .= '&' . $key . '=' . $value;
                }
            }

            $this->embedHTML = "<embed width='{$defaultOptions['width']}' height='{$defaultOptions['height']}'
                                    allowscriptaccess='always' flashvars='autoPlay=true&amp;configParams=playMode%3Dsingle%26psp%3D0'
                                    autoplay='true' allowfullscreen='true' wmode='transparent'
                                    quality='high' bgcolor='#000000' name='swfPlayer'
                                    id='swfPlayer' style='undefined'
                                    src='{$this->getEmbedUrl()}'
                                    type='application/x-shockwave-flash'>";
        }

        return $this->embedHTML;

    }

    /*
     * Returns the FLV url for this Mtvmusic video
     *
     */
    public function getFLV()
    {
        //REXML::XPath.first(@feed, '//media:content').attributes['url'];
        if (!isset($this->FLV)) {
            $this->FLV = $this->getEmbedUrl();
        }

        return $this->FLV;
    }

    /*
     * Returns the Download url for this Mtvmusic video
     *
     */
    public function getDownloadUrl()
    {
        return null;
    }

    /*
     * Returns the name of the Video service
     *
     */
    public function getService()
    {
        return 'Mtvhive';
    }

}
