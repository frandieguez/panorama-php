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
namespace Panorama;
 /*
  * class Video
  */
class Video {
    
    /**
     * The instance of the object we will work into
     */
    private $object = null;
    
    /*
     * __construct()
     * @param $arg
     */
    public function __construct($url = null, $options = null)
    {
        // if nothing is passed in instantiation raise an argument error.
        if(!isset($url) || is_null($url)) {
            throw new ArgumentException("We need a video url");
        }
        
        $serviceName = self::camelize(self::getDomain($url));
        
        // If the service starts with a number prepend a "c" for avoid PHP language error
        if(preg_match("@^\d@",$serviceName)) { $serviceName = "c".$serviceName; }
        $className = "\Panorama\Video\\" . $serviceName;
        
        // If the Video service is supported instantiate it, otherwise raise Exception
        if (file_exists(dirname(__FILE__).DIRECTORY_SEPARATOR."Video".DIRECTORY_SEPARATOR.$serviceName.".php")) {
            $this->object = new $className($url, $options);
        } else {
            throw new \Exception("Video service or Url not supported");
        }
        
    }

  //def initialize(url=nil, options={})
  //  raise ArgumentError.new("We need a video url") if url.blank?
  //  @object ||= "vg_#{get_domain(url).downcase}".camelize.constantize.new(url, options) rescue nil
  //  raise ArgumentError.new("Unsuported url or service") and return if @object.nil?
  //  unless @object.instance_variable_get("@details").nil? || !@object.instance_variable_get("@details").respond_to?("noembed")
  //    raise ArgumentError.new("Embedding disabled by request") and return if @object.instance_variable_get("@details").noembed
  //  end
  //end
  
    /*
     * Returns the video title for the instantiated object.
     * 
     * @returns string, the title of the video
     */
    public function getTitle()
    {
        return $this->object->getTitle();
    }
    
    /*
     * Returns the video thumbnail url for the instantiated object.
     * 
     * @returns string, the thumbnail url of the video
     */
    public function getThumbnail()
    {
        return $this->object->getThumbnail();
    }


    /*
     * Returns the video duration for the instantiated object.
     * 
     * @returns int, the duration of the video
     */
    public function getDuration()
    {
        return $this->object->getDuration();
    }
    
    /*
     * Returns the video embed url for the instantiated object.
     * 
     * @returns string, the embed of the video
     */
    public function getEmbedUrl()
    {
        return $this->object->getEmbedUrl();
    }
    
    /*
     * Returns the video irfor the instantiated object.
     * 
     * @returns string, the id of the video
     */
    public function getVideoID()
    {
        return $this->object->getVideoID();
    }
    
    /*
     * Returns the video embed url for the instantiated object.
     * 
     * @returns string, the embed of the video
     */
    public function getEmbedHTML($options)
    {
        return $this->object->getEmbedHTML($options);
    }
    
    /*
     * Returns the video embed url for the instantiated object.
     * 
     * @returns string, the embed of the video
     */
    public function getFLV()
    {
        return $this->object->getFLV();
    }
    
    /*
     * Returns the video embed url for the instantiated object.
     * 
     * @returns string, the embed of the video
     */
    public function getDownloadUrl()
    {
        return $this->object->getDownloadUrl();
    }
    
    /*
     * Returns the video embed url for the instantiated object.
     * 
     * @returns string, the embed of the video
     */
    public function getService()
    {
        return $this->object->getService();
    }
    
    /*
     * Returns the video embed url for the instantiated object.
     * 
     * @returns string, the embed of the video
     */
    public function getVideoDetails($width = 425, $height = 344)
    {
        $details = array(
                         "title" => $this->object->getTitle(),
                         "thumbnail" => $this->object->getThumbnail(),
                         "embedUrl" => $this->object->getEmbedUrl(),
                         "embedHTML" => $this->object->getEmbedHTML(),
                         "FLV" => $this->object->getFLV(),
                         "downloadUrl" => $this->object->getDownloadUrl(),
                         "service" => $this->object->getService(),
                         "duration" => $this->object->getDuration(),
                         );
        return $details;
    }
  
    /**
    * Returns the given lower_case_and_underscored_word as a CamelCased word.
    *
    * @param string $lower_case_and_underscored_word Word to camelize
    * @return string Camelized word. LikeThis.
    * @access public
    * @static
    * @link http://book.cakephp.org/view/572/Class-methods
    */
	public function camelize($lowerCaseAndUnderscoredWord) {
		return str_replace(" ", "", ucwords(str_replace("_", " ", $lowerCaseAndUnderscoredWord)));
	}
    
    /*
     * Returns the domain string from url
     * 
     * @param $url
     */
    static public function getDomain($url="")
    {
        $host = parse_url($url);
        $domainParts = preg_split("@\.@",$host["host"]);
        
        /**
         * If domain name has a subdomain return the second part
         * if not return the first part
        */
        $domainPartsCount = count($domainParts);
        return $domainParts[$domainPartsCount - 2];

    }
    

}