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
 * class Ted
 * http://www.ted.com/index.php/talks/benjamin_wallace_on_the_price_of_happiness.html
 */
namespace Panorama\Video;

class Ted  {
    
    private $feed = null;
    
    /*
     * __construct()
     * @param $url
     */
    public function __construct($url)
    {
        
        $this->url = $url;
        
        $path = parse_url($url,PHP_URL_PATH);
        if (!preg_match("@talks@",$path)) {
            throw new \Exception("The url '{$this->url}' is not a valid Ted talk url");
        }
        
        $this->page = file_get_contents($this->url);
        
        $this->videoId = $this->getVideoID();
        $this->emb = file_get_contents("http://www.ted.com/talks/embed/id/{$this->videoId}");
        
        $split = preg_split("@param\sname=\"flashvars\"\svalue=\"@",urldecode((string) $this->emb));
        $split = preg_split("@\"@", $split[1]);
        $this->flashvars = $split[0];
        
        $parts = explode("&", $this->flashvars);
        $this->args = array();
        foreach ($parts as $part) {
            $elemParts = explode("=",$part);
            $this->args[$elemParts[0]] = $elemParts[1];
        }
        
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
     * Returns the title for this Ted video
     * 
     */
    public function getTitle()
    {
        preg_match("@<h1><span id=\"altHeadline\">(.*)</span></h1>@",$this->page, $matches);
        return trim($matches[1]);
    }
    
    /*
     * Returns the thumbnail for this Ted video
     * 
     */
    public function getThumbnail()
    {
        return "{$this->args['su']}";
    }
    
    /*
     * Returns the duration in secs for this Ted video
     * 
     */
    public function getDuration()
    {
        return null;
    }
    
    /*
     * Returns the embed url for this Ted video
     * 
     */
    public function getEmbedUrl()
    {
        return "http://video.ted.com/assets/player/swf/EmbedPlayer.swf?{$this->flashvars}";
    }
    
    /*
     * Returns the HTML object to embed for this Ted video
     * 
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
        
        return "<object width='{$defaultOptions['width']}' height='{$defaultOptions['height']}'>
                    <param name='movie' value='{$this->embedUrl}'></param>
                    <param name='allowFullScreen' value='true' />
                    <param name='wmode' value='transparent'></param>
                    <param name='bgColor' value='#ffffff'></param>
                    <embed
                        src='{$this->embedUrl}'
                        pluginspace='http://www.macromedia.com/go/getflashplayer'
                        type='application/x-shockwave-flash'
                        wmode='transparent' bgColor='#ffffff'
                        width='{$defaultOptions['width']}' height='{$defaultOptions['height']}'
                        allowFullScreen='true'>
                    </embed>
                </object>";
    
    }
    
    /*
     * Returns the FLV url for this Ted video
     * 
     */
    public function getFLV()
    {
        return "{$this->args['vu']}";
    }
    
    /*
     * Returns the Download url for this Ted video
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
        return "Ted";
    }
    
    /*
     * Calculate the Video ID from an Ted URL
     * 
     * @param $url
     */
    public function getVideoID()
    {
        preg_match("@itpc://www.ted.com/talks/podtv/id/(\d*)@", $this->page, $matches);
        return (int) $matches[1];
    }
}