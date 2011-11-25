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
 * Wrapper class for Youtube
 *
 * @author Fran Diéguez <fran@openhost.es>
 * @version \$Id\$
 * @copyright OpenHost S.L., Mér Xuñ 01 15:58:58 2011
 * @package Panorama\Video
 **/
namespace Panorama\Video;

class Youtube  implements VideoInterface {
    
    /*
     * __construct()
     * @param $url
     */
    function __construct($url, $options) {
        
        $this->url = $url;
        $this->videoId = $this->getvideoId();
        return $this;
    
    }
    
    /*
     * gets the handler for Youtube web service
     * 
     * @returns object, youtube handler
     */
    public function getServiceHandler()
    {
        // Acces the YouTube API with Zend Gdata Wrapper
        if (!isset($this->handler)) {
            $this->handler = new \Zend_Gdata_YouTube();
        }
        return $this->handler;
    }
    
    /*
     * sets the handler for Youtube web service, useful for using mocking objects
     *
     * @params handler, instantiated object that handles youtube web service request
     * @returns object, youtube handler
     */
    public function setServiceHandler($handler)
    {
        
        return $this->handler = $handler;
        
    }
    
    /*
     * Returns the videoEntry for this video
     * 
     * @returns object, the video entry object from an video id
     */
    public function getVideoEntry()
    {
        if (!isset($this->videoEntry)) {
            try {
                $this->videoEntry = $this->getServiceHandler()->getVideoEntry($this->videoId);
            } catch (Exception $e) {
                throw Exception("Youtube Video with id {$this->videoID} doesn't exists");
            }
        }
        return $this->videoEntry;
    }
    
    /*
     * Returns the video ID from the video url
     * 
     * @returns string, the Youtube ID of this video
     */
    public function getVideoId()
    {
        if (!isset($this->videoId)) {
            $this->videoId =  $this->getUrlParam('v');
        }
        return $this->videoId;
    }
    
    /*
     * Returns the video title
     * 
     */
    public function getTitle()
    {
        
        if (!isset($this->title)) {
            $this->title = $this->getVideoEntry()->getVideoTitle();
        }
        return $this->title;
    }
    
    /*
     * Returns the descrition for this video
     * 
     * @returns string, the description of this video
     */
    public function getDescription()
    {
        if (!isset($this->description)) {
            $this->description = $this->getVideoEntry()->getVideoDescription();
        }
        return $this->description;
    }       
    
    /*
     * Returs the object HTML with a specific width, height and options
     *
     * @param width,   the width of the final flash object
     * @param height,  the height of the final flash object
     * @param options, you can read more about the youtube player options
     *                 in  http://code.google.com/intl/en/apis/youtube/player_parameters.html
     *                 Use them in options (ex {:rel => 0, :color1 => '0x333333'})
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
        
        // convert options into 
        $htmlOptions = "";
        if (count($options) > 0) {
            foreach ($options as $key => $value ) {
                $htmlOptions .= "&" . $key . "=" . $value;
            }
        }
        $embedUrl = $this->getEmbedUrl();
        
        // if this video is not embed
        return "<object width='{$defaultOptions['width']}' height='{$defaultOptions['height']}'>
                    <param name='movie' value='{$embedUrl}{$htmlOptions}'>
                    <param name='allowFullScreen' value='true'>
                    <param name='allowscriptaccess' value='always'>
                    <param name='wmode' value='transparent'>
                    <embed
                        src='{$embedUrl}{$htmlOptions}' type='application/x-shockwave-flash'
                        allowscriptaccess='always' allowfullscreen='true'
                        width='{$defaultOptions['width']}' height='{$defaultOptions['height']}'>
                </object>";
    }
    
    /*
     * Returns the FLV url 
     *
     * @returns string, the url to the video URL
     */
    public function getFLV()
    {
        if (!isset($this->embedUrl)) {
            $this->embedUrl =  $this->getVideoEntry()->getFlashPlayerUrl();
        }
        return $this->embedUrl;
        
    }
    
    /*
     * Returns the embed url of the video
     *
     * @returns string, the embed url of the video
     */
    public function getEmbedUrl()
    {
        if (!isset($this->embedUrl)) {
            $this->embedUrl =  $this->getVideoEntry()->getFlashPlayerUrl();
        }
        return $this->embedUrl;
    }
    
    /*
     * Returns the service name for this video
     *
     * @returns string, the service name of this video
     */
    public function getService()
    {
        return "Youtube";
    }
    
    /*
     * Returns the url for downloading the flv video file
     *
     * @returns string, the url for downloading the flv video file
     */
    public function getDownloadUrl()
    {
        if (!isset($this->embedUrl)) {
            $this->embedUrl =  $this->getVideoEntry()->getFlashPlayerUrl();
        }
        return $this->embedUrl;
    }
    
    /*
     * Returns the duration in sec of the video
     *
     * @returns string, the duration in sec of the video
     */
    public function getDuration()
    {
        if (!isset($this->duration)) {
            $this->duration =  $this->getVideoEntry()->getVideoDuration();
        }
        return $this->duration;
    }
    
    /*
     * Returns the video Thumbnails
     *
     * @returns mixed, the video thumbnails
     */
    public function getThumbnails()
    {
        if (!isset($this->thumbnails)) {
            $this->thumbnails = $this->getVideoEntry()->getVideoThumbnails();
        }
        return $this->thumbnails;
    }
    
    /*
     * Returns the video Thumbnail
     *
     * @returns string, the video thumbnail url
     */
    public function getThumbnail()
    {
        if (!isset($this->thumbnail)) {
            $thumbnails = $this->getThumbnails();
            $this->thumbnail = $thumbnails[0]['url'];
        }
        return $this->thumbnail;
    }
    
    /*
     * Returns the video tags
     *
     * @returns mixed, a list of tags for this video
     */
    public function getTags()
    {
        if (!isset($this->tags)) {
            $this->tags = implode(', ', $this->getVideoEntry()->getVideoTags());
        }
        return $this->tags;
    }
    
    /*
     * Returns the watch url for the video
     *
     * @returns string, the url for watching this video
     */
    public function getWatchUrl()
    {
        if (!isset($this->watchUrl)) {
            $this->watchUrl = $this->getVideoEntry()->getVideoWatchPageUrl();
        }
        return $this->watchUrl;
    }
    
    /**
     * Returns the value of the param given
     *
     * @param string, the param to look for
     * @return string, the value of the param
     */
    private function getUrlParam($param)
    {
        $queryParamsRAW = parse_url($this->url, PHP_URL_QUERY);
        preg_match("@v=([a-zA-Z0-9_-]*)@", $queryParamsRAW, $matches);
        
        return $matches[1];
    }
    
}