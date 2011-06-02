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
 * Wrapper class for Metacafe videos
 *
 * @author Fran Diéguez <fran@openhost.es>
 * @version \$Id\$
 * @copyright OpenHost S.L., Mér Xuñ 01 15:58:58 2011
 * @package Panorama\Video
 **/
namespace Panorama\Video;

class Metacafe implements VideoInterface {
    
    /*
     * __construct()
     * @param $url
     */
    public function __construct($url, $options = null)
    {
        
        $this->url = $url;
        $this->args = $this->getArgs();
        $this->videoId = $this->getVideoId();
        
        $pos = stripos("yt-", $this->args[0]);
        
        $this->youtubed = ($pos == false) ? false : true;
        
        // I can't find a video that comes from Youtube so this snippet is
        // untestable for now
        if ($this->youtubed) {
            $output = preg_split("yt-",$this->args[1]);
            $this->object = new Youtube("http://www.youtube.com/watch?v={$output[1]}");
        }
        
    }
    
    /*
     * Return the video id
     * 
     */
    public function getVideoId()
    {
        if (!isset($this->videoId)) {
            $args = $this->getArgs();
            $this->videoId = $args[0];
        }
        return $this->videoId;
    }
    
    /*
     * Returns the args from video url
     * 
     */
    public function getArgs()
    {
        
        if (!isset($this->args)) {
            
            $uri = parse_url($this->url);
            $path = $uri["path"];
            $this->args = null;
            
            if (isset($path)
                && count(preg_split("@/@", $path)) > 1)
            {
                $args = preg_split("@/@", $path);
                $this->args = array($args[2], $args[3]);
            }
        }
        return $this->args;
    
    }
    
    /*
     * Returns the title for this Metacafe video
     * 
     */
    public function getTitle()
    {
    
        if (!isset($this->title)) {
            if ($this->youtubed) {
                $this->title = $this->object->getTitle();
            } else {
                $this->title = ucfirst(str_replace("_", " ", $this->args[1]));  
            }
        }
        
        return $this->title;
    
    }
    
    /*
     * Returns the thumbnail for this Metacafe video
     * 
     */
    public function getThumbnail()
    {
        
        if (!isset($this->thumbnail)) {
            $args = $this->getArgs();
            $this->thumbnail = "http://www.metacafe.com/thumb/{$args[0]}.jpg";
        }
        return $this->thumbnail;

    }
    
    /*
     * Returns the duration in secs for this Metacafe video
     * 
     */
    public function getDuration()
    {
        return null;
    }
    
    /*
     * Returns the embed url for this Metacafe video
     * 
     */
    public function getEmbedUrl()
    {

        if (!isset($this->embedUrl)) {
            $params = implode("/", $this->getArgs());
            $this->embedUrl = "http://www.metacafe.com/fplayer/{$params}.swf";
        }
        return $this->embedUrl;
    
    }
    
    /*
     * Returns the HTML object to embed for this Metacafe video
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
                foreach ($options as $key => $value ) {
                    $htmlOptions .= '&' . $key . '=' . $value;
                }
            }
                                    
            $this->embedHTML = "<embed
                                    src='{$this->getEmbedUrl()}'
                                    width='{$defaultOptions['width']}' height='{$defaultOptions['height']}'
                                    wmode='transparent'
                                    pluginspage='http://www.macromedia.com/go/getflashplayer'
                                    type='application/x-shockwave-flash'>
                                </embed>";
        }
        return $this->embedHTML;
    
    }
    
    /*
     * Returns the FLV url for this Metacafe video
     * 
     */
    public function getFLV()
    {
        return "";

        if (!isset($this->FLV)) {

            // Translate ruby code
            $finalUrl = urldecode(self::getFinalRedirect($this->getEmbedUrl()));

            // Problem this info is not available
            preg_match("@key\":\"(.*)\"}@", $finalUrl, $params);
            $key = $params[1];

            preg_match("@mediaURL\":\"(.*)\",@", $finalUrl, $params);
            $mediaUrl = preg_replace("/\\\/", "", $params[1]);
            
            $this->FLV = "{$mediaUrl}?__gdk__={$key}";
            
        }
        return $this->FLV;
    }
    
    /*
     * Returns the Download url for this Metacafe video
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
        return 'Metacafe';
    }
    
    
    /**
     * getRedirectUrl()
     * Gets the address that the provided URL redirects to,
     * or FALSE if there's no redirect. 
     *
     * @param string $url
     * @return string
     */
    static public function getRedirectUrl($url){
        $redirect_url = null; 
     
        $url_parts = @parse_url($url);
        if (!$url_parts) return false;
        if (!isset($url_parts['host'])) return false; //can't process relative URLs
        if (!isset($url_parts['path'])) $url_parts['path'] = '/';
     
        $sock = fsockopen($url_parts['host'], (isset($url_parts['port']) ? (int)$url_parts['port'] : 80), $errno, $errstr, 30);
        if (!$sock) return false;
     
        $request = "HEAD " . $url_parts['path'] . (isset($url_parts['query']) ? '?'.$url_parts['query'] : '') . " HTTP/1.1\r\n"; 
        $request .= 'Host: ' . $url_parts['host'] . "\r\n"; 
        $request .= "Connection: Close\r\n\r\n"; 
        fwrite($sock, $request);
        $response = '';
        while(!feof($sock)) $response .= fread($sock, 8192);
        fclose($sock);
     
        if (preg_match('/^Location: (.+?)$/m', $response, $matches)){
            if ( substr($matches[1], 0, 1) == "/" )
                return $url_parts['scheme'] . "://" . $url_parts['host'] . trim($matches[1]);
            else
                return trim($matches[1]);
     
        } else {
            return false;
        }
     
    }
     
    /**
     * getAllRedirects()
     * Follows and collects all redirects, in order, for the given URL. 
     *
     * @param string $url
     * @return array
     */
    static private function getAllRedirects($url){
        $redirects = array();
        while ($newurl = self::getRedirectUrl($url)){
            if (in_array($newurl, $redirects)){
                break;
            }
            $redirects[] = $newurl;
            $url = $newurl;
        }
        return $redirects;
    }
     
    /**
     * getFinalRedirect()
     * Gets the address that the URL ultimately leads to. 
     * Returns $url itself if it isn't a redirect.
     *
     * @param string $url
     * @return string
     */
    static private function getFinalRedirect($url){
        $redirects = self::getAllRedirects($url);
        if (count($redirects)>0){
            return array_pop($redirects);
        } else {
            return $url;
        }
    }

}