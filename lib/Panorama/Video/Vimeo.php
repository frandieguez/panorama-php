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
 * Wrapper class for Vimeo
 *
 * @author Fran Diéguez <fran@openhost.es>
 * @version \$Id\$
 * @copyright OpenHost S.L., Mér Xuñ 01 15:58:58 2011
 * @package Panorama\Video
 **/
namespace Panorama\Video;

class Vimeo implements VideoInterface
{
    private $feed = null;

    /*
     * __construct()
     * @param $url
     */
    public function __construct($url)
    {
        $this->url = $url;
        $this->videoId = $this->getVideoID($this->url);
        $this->getFeed();
    }

    /*
     * Returns the feed that contains information of video
     *
     */
    public function getFeed()
    {
        if (!isset($this->feed)) {
            $videoId = $this->getVideoID();

            $document = file_get_contents("http://vimeo.com/api/v2/video/".$videoId.".php");
            if (!$document) {
                throw new \Exception('Video Id not valid.');
            }
            $information = unserialize($document);
            $this->feed = $information[0];
        }

        return $this->feed;
    }

    /*
     * Sets the feed that contains information of video, usefull for using mocking objects
     *
     * @param $feed,
     */
    public function setFeed($feed)
    {
        $this->feed = $feed;
    }

    /*
     * Returns the title for this Vimeo video
     *
     * @return string, the title for this Vimeo video
     */
    public function getTitle()
    {
        if (!isset($this->title)) {
            $this->title = (string) $this->feed['title'];
        }

        return $this->title;
    }

    /*
     * Returns the thumbnails for this Vimeo video
     *
     * @return string, the HTML object to embed for this Vimeo video
     */
    public function getThumbnail()
    {
        if (!isset($this->thumbnail)) {
            $this->thumbnail = (string) $this->feed['thumbnail_large'];
        }

        return $this->thumbnail;
    }

    /*
     * Returns the duration in secs for this Vimeo video
     *
     */
    public function getDuration()
    {
        if (!isset($this->duration)) {
            $this->duration = (string) $this->feed['duration'];
        }

        return $this->duration;
    }

    /*
     * Returns the embed url for this Vimeo video
     *
     * @return string, the embed url for this Vimeo video
     */
    public function getEmbedUrl()
    {
        if (!isset($this->embedUrl)) {
            $videoId = $this->getVideoId();
            $this->embedUrl = "http://player.vimeo.com/video/".$this->getVideoID();;
        }

        return $this->embedUrl;
    }

    /*
     * Returns the HTML object to embed for this Vimeo video
     *
     * @param mixed, options to modify the final HTML
     * @return string, the HTML object to embed for this Vimeo video
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

            // convert options into
            $htmlOptions = "";
            if (count($options) > 0) {
              foreach ($options as $key => $value ) {
                  $htmlOptions .= "&" . $key . "=" . $value;
              }
            }
            $embedUrl = $this->getEmbedUrl();

            $this->embedHTML =
            '<iframe src="'.$this->getEmbedUrl()
            .'" width="'.$defaultOptions['width'].'" height="'.$defaultOptions['height'].'" '
            .'frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
        }

        return $this->embedHTML;

    }

    /*
     * Returns the FLV url for this Vimeo video
     *
     * @returns string, the FLV url for this Vimeo video
     */
    public function getFLV()
    {

        if (!isset($this->FLV)) {
            $this->FLV =  "http://player.vimeo.com/video/".$this->getVideoID();
        }

        return $this->FLV;

    }

    /*
     * Returns the Download url for this Vimeo video
     *
     * @returns string, the Download url for this Vimeo video
     */
    public function getDownloadUrl()
    {
        return $this->getFLV();
    }

    /*
     * Returns the name of the Video service
     *
     * @returns string, the name of the Video service
     *
     */
    public function getService()
    {
        return "Vimeo";
    }

    /*
     * Calculate the Video ID from an Vimeo URL
     *
     * @param $url
     * @return string,    the Video ID from an Vimeo URL
     * @throws Exception, if path is not valid
     */
    public function getVideoID($url="")
    {

        if (!isset($this->videoId)) {
            try {

                $uri = parse_url($url);

                if (isset($uri['fragment'])) {

                    $this->videoId = $uri['fragment'];

                } elseif (isset($uri["path"])) {

                    $pathParts = preg_split("@/@",$uri['path']);
                    if (count($pathParts) > 0) {
                        $this->videoId = $pathParts[1];
                    } else {
                        throw \Exception("The path {$url} sems to be invalid");
                    }

                }

            } catch (Exception $e) {
                throw \Exception("The path {$url} sems to be invalid");
            }
        }

        return $this->videoId;

    }
}
