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
/*
 * class MySpace
 * http://qik.com/video/340982
 */
namespace Panorama\Video;

class Myspace  {
    
    
    /*
     * __construct()
     * @param $url
     */
    public function __construct($url, $options = null)
    {
        
        $this->url = $url;
        $this->videoId = $this->getVideoID();
        
        $this->page = file_get_contents("http://mediaservices.myspace.com/services/rss.ashx?type=video&videoID={$this->getVideoID()}");
        
        $this->feed = simplexml_load_string($this->page);
        
        $this->title = $this->getTitle();
        $this->thumbnail = $this->getThumbnail();
        $this->duration = $this->getDuration();
        $this->embedUrl = $this->getEmbedUrl();
        $this->embedHTML = $this->getEmbedHTML();
        $this->FLV = $this->getFLV();
        $this->downloadUrl = $this->getEmbedUrl();
        $this->service = $this->getService();
        
    }
    
    /*
     * Returns the title for this MySpace video
     * 
     */
    public function getTitle()
    {
        if (!isset($this->title)) {
            $titles = $this->feed->xpath('//item/title');
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
            $thumbnails = $this->feed->xpath('//item/media:thumbnail');
            $this->thumbnail = (string) $thumbnails[0]["url"];
        }
        return $this->thumbnail;

    }
    
    /*
     * Returns the duration in secs for this MySpace video
     * 
     */
    public function getDuration()
    {
        return null;
    }
    
    /*
     * Returns the embed url for this MySpace video
     * 
     */
    public function getEmbedUrl()
    {
        if (!isset($this->embedUrl)) {
            $item = $this->feed->xpath('//myspace:itemID');
            $itemID = (string) $item[0];
            $this->embedUrl = "http://lads.myspace.com/videos/vplayer.swf?m={$itemID}&v=2&type=video";
        }
        return $this->embedUrl;
    }
    
    /*
     * Returns the HTML object to embed for this MySpace video
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
            $htmlOptions = "";
            if (count($options) > 0) {
                foreach ($options as $key => $value ) {
                    $htmlOptions .= "&" . $key . "=" . $value;
                }
            }
                  
            $this->embedHTML = "<embed src='{$this->getEmbedUrl()}'
                                    width='{$defaultOptions['width']}' height='{$defaultOptions['height']}'
                                    type='application/x-shockwave-flash'>
                                </embed>";
        }
        return $this->embedHTML;
    
    }
    
    /*
     * Returns the FLV url for this MySpace video
     * 
     */
    public function getFLV()
    {
        //REXML::XPath.first(@feed, "//media:content").attributes['url'];
        if (!isset($this->FLV)) {
            $item = $this->feed->xpath('//media:content');
            $this->FLV = (string) $item[0]["url"];
        }
        return $this->FLV;
    }
    
    /*
     * Returns the Download url for this MySpace video
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
        return "Myspace";
    }
    
    /*
     * Calculates the Video ID from an MySpace URL
     * 
     * @param $url
     */
    public function getVideoID()
    {

        if (!isset($this->videoId)) {
            //@video_id = @url.query_param('videoid').blank? ? @url.query_param('VideoID') : @url.query_param('videoid')
            preg_match("@videoid=(\w*)@", $this->url,$matches);
            if (count($matches) > 0) {
                $this->videoId = $matches[1];
            } else {
                preg_match("@VideoID=(\w*)@", $this->url,$matches);
                $this->videoId = $matches[1];
            }
        }
        return $this->videoId;

    }
}