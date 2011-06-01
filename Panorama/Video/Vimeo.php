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
 * class Vimeo
 */
namespace Panorama\Video;

class Vimeo  {
    
    private $feed = null;
    
    /*
     * __construct()
     * @param $url
     */
    public function __construct($url)
    {
        
        $this->url = $url;
        $this->videoId = $this->getVideoID($this->url);
        
        $document = file_get_contents("http://vimeo.com/moogaloop/load/clip:{$this->videoId}/embed?param_server=vimeo.com&param_clip_id=#{$this->videoId}");
        $this->feed = simplexml_load_string($document);
        
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
     * Returns the title for this Vimeo video
     * 
     */
    public function getTitle()
    {
        $titles = $this->feed->xpath('//caption');
        return (string) $titles[0];
    }
    
    /*
     * Returns the thumbnail for this Vimeo video
     * 
     */
    public function getThumbnail()
    {
        $thumbnails = $this->feed->xpath('//thumbnail');
        return (string) $thumbnails[0];
    }
    
    /*
     * Returns the duration in secs for this Vimeo video
     * 
     */
    public function getDuration()
    {
        $duration = $this->feed->xpath('//duration');
        return (int) $duration[0];
    }
    
    /*
     * Returns the embed url for this Vimeo video
     * 
     */
    public function getEmbedUrl()
    {
        return "http://vimeo.com/moogaloop.swf?clip_id={$this->videoId}&server=vimeo.com&fullscreen=1&show_title=1&show_byline=1&show_portrait=1";
    }
    
    /*
     * Returns the HTML object to embed for this Vimeo video
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
                    <param name='movie' value='{$embedUrl}{$htmlOptions}'></param>
                    <param name='allowFullScreen' value='true'></param>
                    <param name='allowscriptaccess' value='always'></param>
                    <param name='wmode' value='transparent'></param>
                    <embed
                        src='{$embedUrl}{$htmlOptions}' type='application/x-shockwave-flash'
                        allowscriptaccess='always' allowfullscreen='true'
                        width='{$defaultOptions['width']}' height='{$defaultOptions['height']}'>
                    </embed>
                </object>";
    
    }
    
    /*
     * Returns the FLV url for this Vimeo video
     * 
     */
    public function getFLV()
    {
        $requestSignature = $this->feed->xpath('//request_signature');
        $requestSignature = (string) $requestSignature[0];
        
        $requestSignatureExpires = $this->feed->xpath('//request_signature_expires');
        $requestSignatureExpires = (string) $requestSignature[0];
        
        return "http://www.vimeo.com/moogaloop/play/clip:#{@video_id}/{$requestSignature}/{$requestSignatureExpires}/";
    
    }
    
    /*
     * Returns the Download url for this Vimeo video
     * 
     */
    public function getDownloadUrl()
    {
        $requestSignature = $this->feed->xpath('//request_signature');
        $requestSignature = (string) $requestSignature[0];
        
        $requestSignatureExpires = $this->feed->xpath('//request_signature_expires');
        $requestSignatureExpires = (string) $requestSignature[0];
        
        return "http://www.vimeo.com/moogaloop/play/clip:#{@video_id}/{$requestSignature}/{$requestSignatureExpires}/?q=hd";
    
    }
    
    /*
     * Returns the name of the Video service
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
     */
    public function getVideoID($url="")
    {
        
        if (isset($this->videoID)) {
            return $this->videoID;
        }
    
        try {
            
            $uri = parse_url($url);
            
            if (isset($uri['fragment'])) {
                return $uri['fragment'];
            }
            
            if(isset($uri["path"])) {
                $pathParts = preg_split("@/@",$uri['path']);
                if (count($pathParts) > 0) {
                    return (string) $pathParts[1];
                } else {
                    throw \Exception("The Path {$pathParts} doesn't have enought length");
                }
            }
            
        } catch (Exception $e) {
            return null;
        }
    }
}