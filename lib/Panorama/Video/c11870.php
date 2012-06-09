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
 * Wrapper class for 11870 videos
 *
 * @package Panorama\Video
 * @author Fran Diéguez <fran@openhost.es>
 **/
namespace Panorama\Video;

class c11870 implements VideoInterface
{
    /*
     * __construct()
     * @param string $url the url for this video
     */
    public function __construct($url)
    {
        $this->url = $url;
        $this->getHash();
    }

    /*
     * Fetchs the contents of the 11870 video page
     *
     * @return string the content of the page
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
     * @param  string $page the content of the page
     * @return object the object of this video, for allowing chaining methods
     */
    public function setPage($page = '')
    {
        if (!empty($page)) {
            $this->page = $page;
        }

        return $this;
    }

    /*
     * Returns the video id, allways null, not applicable
     *
     * @return null not aplicable for this service
     */
    public function getVideoId()
    {
        return null;
    }

    /*
     * Returns the title for this 11870 video
     *
     * @return string the title of this video
     */
    public function getTitle()
    {
        if (!isset($this->title)) {
            preg_match('@<title>(.*)</title>@', $this->getPage(), $matches);
            $title = preg_split('@ - www.11870.com@', $matches[1]);
            $this->title = iconv('ISO-8859-1', 'UTF-8', (string) $title[0]);

        }

        return $this->title;
    }

    /*
     * Returns the thumbnail url for this 11870 video
     *
     * @return string the thumbnail url for this video
     */
    public function getThumbnail()
    {
        if (!isset($this->thumbnail)) {
            $hash = $this->getHash();
            $this->thumbnail = $hash['image'];
        }

        return $this->thumbnail;
    }

    /*
     * Returns the duration in secs for this 11870 video
     *
     * @return null not aplicable for this service
     */
    public function getDuration()
    {
        return null;
    }

    /*
     * Returns the embed url for this 11870 video
     *
     * @return string the embed url for this video, to insert in Flash (C)
     */
    public function getEmbedUrl()
    {
        if (!isset($this->embedUrl)) {
            $hash = $this->getHash();
            $this->embedUrl = "http://m2.11870.com/multimedia/11870/player.swf?"
                            . $this->getFlashVars() . "&logo=" . $hash['logo'];
        }

        return $this->embedUrl;
    }

    /*
     * Returns the HTML object to embed for this 11870 video
     *
     * @return string the html swf for this video
     */
    public function getEmbedHTML($options = array())
    {
        $defaultOptions = array(
              'width' => 560,
              'height' => 349
            );

        $options = array_merge($defaultOptions, $options);
        unset($options['width']);
        unset($options['height']);

        // convert options into url encoded string
        $htmlOptions = "";
        if (count($options) > 0) {
            foreach ($options as $key => $value) {
                $htmlOptions .= "&" . $key . "=" . $value;
            }
        }

        return "<object type='application/x-shockwave-flash'\n"
                ."data='http://11870.com/multimedia/11870/player.swf'\n"
                ."width='{$defaultOptions['width']}' "
                ."height='{$defaultOptions['height']}'\n"
                ."bgcolor='#000000'>\n"
                ."<param name='movie' value='{$this->getEmbedUrl()}' />\n"
                ."<param name='allowfullscreen' value='true'>\n"
                ."<param name='allowscriptaccess' value='always'>\n"
                ."<param name='seamlesstabbing' value='true'>\n"
                ."<param name='wmode' value='window'>\n"
                ."<param name='flashvars' value='{$this->getFlashVars()}'>\n"
                ."</object>";
    }

    /*
     * Returns the FLV url for this 11870 video
     *
     * @return string the FLV url for this 11870 video
     */
    public function getFLV()
    {
        if (!isset($this->FLV)) {
            $hash = $this->getHash();
            $this->FLV = $hash['file'];
        }

        return $this->FLV;
    }

    /*
     * Returns the Download url for this 11870 video
     *
     * @return strin the FLV url for this 11870 video
     */
    public function getDownloadUrl()
    {
        return $this->getFLV();
    }

    /*
     * Returns the name of the Video service
     *
     * @return string the name of the video service
     */
    public function getService()
    {
        return "11870";
    }

    /*
     * Returns the flashvars
     *
     * @return string the flash vars, useful for the embedHTML
     */
    public function getFlashVars()
    {
        if (!isset($this->flashvars)) {
            preg_match(
                '@flashvars=&quot;(\S+)&quot;@',
                $this->getPage(),
                $matches
            );
            $this->flashvars = $matches[1];
        }

        return $this->flashvars;
    }

    /*
     * Calculates the Video ID from an 11870 URL
     *
     * @return array an key-value pairs with information about the video
     */
    public function getHash()
    {
        if (!isset($this->hash)) {
            $flashVarsArray = preg_split('@&@', $this->getFlashVars());
            foreach ($flashVarsArray as $match) {
                $partialMatch = preg_split('@=@', $match);
                $this->hash[$partialMatch[0]] = $partialMatch[1];
            }
            unset($this->hash['displaywidth']);
        }

        return $this->hash;
    }
}
