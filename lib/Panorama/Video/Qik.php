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
 * Wrapper class for Qik videos
 *
 * @author Fran Diéguez <fran@openhost.es>
 * @version \$Id\$
 * @copyright OpenHost S.L., Mér Xuñ 01 15:58:58 2011
 * @package Panorama\Video
 **/
namespace Panorama\Video;

class Qik
{
    /*
     * __construct()
     * @param $url
     */
    public function __construct($url)
    {
        throw new \Exception("Not implemented");

        $this->url = $url;

        $this->page = file_get_contents("http://qik.com/video/{$this->getVideoID()}");

        var_dump("http://qik.com/video/{$this->getVideoID()}");
        die();

        $split = preg_split(
            "@<input\sname=\"flashvars\"\svalue=\"@",
            urldecode((string) $this->emb)
        );
        $split = preg_split("@\"@", $split[1]);

        //-------

        $this->videoId     = $this->getVideoID();
        $this->title       = $this->getTitle();
        $this->thumbnail   = $this->getThumbnail();
        $this->duration    = $this->getDuration();
        $this->embedUrl    = $this->getEmbedUrl();
        $this->embedHTML   = $this->getEmbedHTML();
        $this->FLV         = $this->getFLV();
        $this->downloadUrl = $this->getEmbedUrl();
        $this->service     = $this->getService();

    }

    /*
     * Returns the title for this Qik video
     *
     */
    public function getTitle()
    {
        //REXML::XPath.first(@feed, "//item/title")[0].to_s
        if (!isset($this->title)) {

        }

        return $this->title;
    }

    /*
     * Returns the thumbnail for this Qik video
     *
     */
    public function getThumbnail()
    {
        //REXML::XPath.first(@feed, "//item/media:thumbnail").attributes['url']
        if (!isset($this->thumbnail)) {

        }

        return $this->thumbnail;
    }

    /*
     * Returns the duration in secs for this Qik video
     *
     */
    public function getDuration()
    {
        return null;
    }

    /*
     * Returns the embed url for this Qik video
     *
     */
    public function getEmbedUrl()
    {
        if (!isset($this->embedUrl)) {
            $this->embedUrl = "http://qik.com/swfs/qikPlayer4.swf?rssURL={$this->getFeedUrl()}&autoPlay=false";
        }

        return $this->embedUrl;
    }

    /*
     * Returns the HTML object to embed for this Qik video
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
            foreach ($options as $key => $value) {
                $htmlOptions .= "&" . $key . "=" . $value;
            }
        }

        return "<object classid='clsid:d27cdb6e-ae6d-11cf-96b8-444553540000' id='qikPlayer' align='middle'
                    codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0'
                    width='{$defaultOptions['width']}' height='{$defaultOptions['height']}' >
                    <param name='allowScriptAccess' value='sameDomain' />
                    <param name='allowFullScreen' value='true' />
                    <param name='movie' value='{$this->getEmbedUrl()}' />
                    <param name='quality' value='high' />
                    <param name='bgcolor' value='#333333' />
                    <embed src='{$this->getEmbedUrl()}' quality='high' bgcolor='#333333'
                        width='{$defaultOptions['width']}' height='{$defaultOptions['height']}'
                        name='qikPlayer' align='middle' allowScriptAccess='sameDomain'
                        allowFullScreen='true' type='application/x-shockwave-flash'
                        pluginspage='http://www.macromedia.com/go/getflashplayer'/>
                </object>";

    }

    /*
     * Returns the FLV url for this Qik video
     *
     */
    public function getFLV()
    {
        //REXML::XPath.first(@feed, "//item/media:content[@type='video/x-flv']").attributes['url']
    }

    /*
     * Returns the Download url for this Qik video
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
        return "Qik";
    }

    /*
     * Calculates the Video ID from an Qik URL
     *
     * @param $url
     */
    public function getVideoID()
    {

        if (!isset($this->videoId)) {
            $path = parse_url($this->url);
            if (isset($path["fragments"])) {
                $pieces = preg_split("@#@",$path);
                $this->videoId = $pieces['v'];
            } else {
                $pieces = preg_split("@/@",$path["path"]);
                $this->videoId = $pieces[count($pieces)-1];
            }
        }

        return $this->videoId;

    }
}
