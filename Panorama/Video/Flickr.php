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
namespace Panorama\Video;

/*
 * class Flickr
 */
class Flickr implements VideoInterface {
    
    public $flickrConnection = null;
    public $flickrAuthKeys   = null;
    
    /*
     * __construct()
     * @param $params
     */
    public function __construct($url)
    {
        $this->url = $url;
        
        $this->setFlickrAuth();
        $this->params = array(
            'api_key'	=> $this->flickrAuthKeys['flickr_key'],
            'method'	=> 'flickr.photos.getInfo',
            'photo_id'	=> $this->getVideoId(),
            'format'	=> 'php_serial',
        );
        
        //$this->getFlickrconnection();
    }
    
    /*
     * Sets the authentication keys for accessing Flickr web service
     * 
     */
    public function setFlickrAuth($params = array())
    {
        
        if (is_null($this->flickrAuthKeys)) {
            
            if (defined('FLICKR_KEY')
                && defined('FLICKR_SECRET_KEY'))
            {
                $this->flickrAuthKeys = array(
                    'flickr_key' => FLICKR_KEY,
                    'flickr_secret_key' => FLICKR_SECRET_KEY,                
                );
            }
            
            if (isset($params['flickr_key'])
                && isset($params['flickr_secret_key']))
            {
                $this->flickrAuthKeys = array(
                    'flickr_key' => $params['flickr_key'],
                    'flickr_secret_key' => $params['flickr_secret_key'],
                );
            }
            
            if (is_null($this->flickrAuthKeys)) {
                throw new \Exception('You must provide the flickr_key and flickr_secret_key.');
            }
            
        }
        return $this;
        
    }
    
    
    /*
     * Initializes the Flickr connection
     *
     * @returns object, array with information of the video
     */
    public function getFlickrObject()
    {
        if (!isset($this->object)) {
            
            $encoded_params = array();
            foreach ($this->params as $k => $v){
                $encoded_params[] = urlencode($k).'='.urlencode($v);
            }
            
            $url = "http://api.flickr.com/services/rest/?".implode('&', $encoded_params);
            
            $rsp = file_get_contents($url);
            $rsp_obj = unserialize($rsp);
            
            if ($rsp_obj['stat'] == 'ok'){
                $this->object = $rsp_obj['photo'];
                if ($this->object['media'] != 'video') {
                    throw new \Exception("This element is not a video");
                }
            }else{
                throw new \Exception("Something wrong happened while accesing the flickr API.");
            }   
        }
        return $this->object;
    }

    /**
     * Returns the download url for the video
    */
    public function getDownloadUrl()
    {
        
    }
    
    /**
     * Returns the video duration in secs
    */
    public function getDuration()
    {
        return null;
    }
    
    /**
     * Returns the video embedHTML for put in a webpage
    */
    public function getEmbedHTML($options = array())
    {
        $defaultOptions = array(
              'width' => 560,
              'height' => 349 
              );
        
        $options = array_merge($defaultOptions, $options);
        
        
        // convert options into 
        $htmlOptions = "";
        if (count($options) > 0) {
            foreach ($options as $key => $value ) {
                $htmlOptions .= "&" . $key . "=" . $value;
            }
        }
        
        return "<object type='application/x-shockwave-flash'
                    width='{$options['width']}' height='{$options['height']}'
                    data='http://www.flickr.com/apps/video/stewart.swf?v=63881'
                    classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000'>
                    <param name='movie' value='{$this->getEmbedUrl()}'></param>
                    <param name='bgcolor' value='#000000'></param>
                    <param name='allowFullScreen' value='true'></param>
                    <embed type='application/x-shockwave-flash'
                        src='{$this->getEmbedUrl()}'
                        bgcolor='#000000' allowfullscreen='true'
                        width='{$options['width']}' height='{$options['height']}'>
                    </embed>
                </object>";
        
    }
    
    /**
     * Returns the url of the video for embed in custom flash player 
    */
    public function getEmbedUrl()
    {
        if (!isset($this->embedUrl)) {
            $videoId = $this->getVideoId();
            $object = $this->getFlickrObject();
            
            $this->embedUrl =   "http://www.flickr.com/apps/video/stewart.swf?v=63881&intl_lang=en-us"
                                ."&photo_secret={$object['secret']}&photo_id={$videoId}";
        }
        return $this->embedUrl;
    }
    
    /**
     * Returns the url of the video in FLV format
    */
    public function getFLV()
    {
        return "Not yet implemented";

        if (!isset($this->FLV)) {
            $videoObject = $this->getFlickrObject();
            $playerUrl =   "http://www.flickr.com/apps/video/video_mtl_xml.gne?v=x"
                            ."&photo_id={$this->getVideoId()}&secret={$videoObject['secret']}"
                            ."&olang=en-us&noBuffer=null&bitrate=700&target=_blank";
            $playerXML = simplexml_load_string(file_get_contents($playerUrl));
            $dataIdXpath = $playerXML->xpath("//Data/Item[@id='id']");
            $dataId = $dataIdXpath;
        }
        //player_feed = "http://www.flickr.com/apps/video/video_mtl_xml.gne?v=x&photo_id=#{@video_id}&secret=#{@details.secret}&olang=en-us&noBuffer=null&bitrate=700&target=_blank"
        //res = Net::HTTP.get(URI::parse(player_feed))
        //player_feed_xml = REXML::Document.new(res)
        //data_id = REXML::XPath.first(player_feed_xml, "//Data/Item[@id='id']")[0].to_s
        //
        //video_feed = "http://www.flickr.com/video_playlist.gne?node_id=#{data_id}&tech=flash&mode=playlist&lq=j2CW2jbpqCLKRy_s4bTylH&bitrate=700&secret=#{@details.secret}&rd=video.yahoo.com-offsite&noad=1"
        //res = Net::HTTP.get(URI::parse(video_feed))
        //video_feed_xml = REXML::Document.new(res)
        //stream = REXML::XPath.first(video_feed_xml, "//DATA/SEQUENCE-ITEM/STREAM")
        //"#{stream.attributes['APP']}#{stream.attributes['FULLPATH']}"
    }
    
    /**
     * Returns the service name of the video
    */
    public function getService()
    {
        return "Flickr";
    }
    
    /**
     * Returns the default thumbnail of this video
     *
     * @return the default thumbnail of this video
    */
    public function getThumbnail()
    {
        if (!isset($this->thumbnail)) {
            //@details.source('Small')
            $object = $this->getFlickrObject();
            $this->thumbnail = "http://farm{$object['farm']}.static.flickr.com/{$object['server']}/{$object['id']}_{$object['secret']}_s.jpg";
        }
        return $this->thumbnail;
    }
    
    /**
     * Returns the title of this video
     *
     * @return string, the title of this video
    */
    public function getTitle()
    {
        if (!isset($this->title)) {
            $videoId = $this->getVideoId();
            $object = $this->getFlickrObject();
            
            $this->title = $object['title']['_content'];
        }
        return $this->title;
    }
    
    /**
     * Returns the internal video id in the particular service
     *
     * @return string, the video ID for the given url.
    */
    public function getVideoId()
    {
        if (!isset($this->videoId)) {
            $url = parse_url($this->url);
            $path = preg_split("@/@", $url["path"]);
            $this->videoId = $path[count($path)-1];
        }
        return $this->videoId;
    }

}