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
 * Wrapper class for Marca TV videos
 *
 * @author Fran Diéguez <fran@openhost.es>
 * @version \$Id\$
 * @copyright OpenHost S.L., Mér Xuñ 01 15:58:58 2011
 * @package Panorama\Video
 **/
namespace Panorama\Video;

class Marca implements VideoInterface {
    
    /*
     * __construct()
     * @param $url
     */
    public function __construct($url)
    {

        $this->url = $url;
        $this->videoId = $this->getVideoID();
        
        $sub1 = substr($this->videoId,0,1);
        $sub2 = substr($this->videoId,1,1);
        $sub3 = substr($this->videoId,2,100);
        
        $doc = file_get_contents("http://estaticos.marca.com/consolamultimedia/marcaTV/elementos/{$sub1}/{$sub2}/{$sub3}.xml");
        $this->feed = simplexml_load_string($doc);
        
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
     * Returns the title for this Marca video
     * 
     */
    public function getTitle()
    {
        if (!isset($this->title)) {
            $title = $this->feed->xpath('//titulo');
            $this->title = (string) $title[0];
        }
        return $this->title;
    }
    
    /*
     * Returns the thumbnail for this Marca video
     * 
     */
    public function getThumbnail()
    {
        if (!isset($this->thumbnail)) {
            $tmb = $this->feed->xpath('//foto');
            return (string) $tmb[0];
        }
        return $this->thumbnail;
    }
    
    /*
     * Returns the duration in secs for this Marca video
     * 
     */
    public function getDuration()
    {
        return null;
    }
    
    /*
     * Returns the embed url for this Marca video
     * 
     */
    public function getEmbedUrl()
    {
        return "http://www.marca.com/componentes/flash/embed.swf?ba=0&cvol=1&bt=1&lg=1&vID={$this->videoId}&ba=1";
    }
    
    /*
     * Returns the HTML object to embed for this Marca video
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
        
        return "<embed
                    src='{$this->getEmbedUrl()}'
                    width='{$defaultOptions['width']}' height='{$defaultOptions['height']}'
                    wmode='transparent' pluginspage='http://www.macromedia.com/go/getflashplayer'
                    type='application/x-shockwave-flash'
                    allowfullscreen='true'
                    quality='high' />";
    
    }
    
    /*
     * Returns the FLV url for this Marca video
     * 
     */
    public function getFLV()
    {
        if (!isset($this->FLV)) {
            $FLV = $this->feed->xpath('//media');
            $this->FLV = (string) $FLV[0];
        }
        return $this->FLV;
    }
    
    /*
     * Returns the Download url for this Marca video
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
        return "Marca";
    }
    
    /*
     * Calculates the Video ID from an Marca URL
     * 
     * @param $url
     */
    public function getVideoID()
    {

        if (!isset($this->videoId)) {
            $path = parse_url($this->url, PHP_URL_QUERY);
            preg_match("@v=(\w*)@", $path, $matches);
            $this->videoId = $matches[1];
        }
        return $this->videoId;

    }
}