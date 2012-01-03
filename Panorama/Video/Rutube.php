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
 * Wrapper class for Rutube videos
 *
 * @author Fran Diéguez <fran@openhost.es>
 * @version \$Id\$
 * @copyright OpenHost S.L., Mér Xuñ 01 15:58:58 2011
 * @package Panorama\Video
 **/
namespace Panorama\Video;

class Rutube implements VideoInterface {

    private $rtXmlAPIUrl = "http://rutube.ru/cgi-bin/xmlapi.cgi";

    /*
     * __construct()
     * @param $url
     */
    public function __construct($url)
    {

        $this->url = $url;

    }

    /*
     * Returns the title for this Rutube video
     *
     */
    public function getTitle()
    {
        //rt_info["movie"][0]["title"][0].strip
        if (!isset($this->title)) {
            $rtInfo = $this->getRtInfo();
            $this->title = trim((string) $rtInfo->movie[0]->title);
        }

        return $this->title;
    }

    /*
     * Returns the thumbnail for this Rutube video
     *
     */
    public function getThumbnail()
    {
        if (!isset($this->thumbnail)) {
            $size = 2;
            $movieHash = $this->getMovieHash();
            $sub1 = substr($movieHash,0,2);
            $sub2 = substr($movieHash,2,2);
            $this->thumbnail = "http://img.rutube.ru/thumbs/{$sub1}/{$sub2}/{$movieHash}-{$size}.jpg";
        }
        return $this->thumbnail;
    }

    /*
     * Returns the duration in secs for this Rutube video
     *
     */
    public function getDuration()
    {
        return null;
    }

    /*
     * Returns the embed url for this Rutube video
     *
     */
    public function getEmbedUrl()
    {
        $movieHash = $this->getMovieHash();
        return "http://video.rutube.ru/{$movieHash}";
    }

    /*
     * Returns the movie hash to make request to Rutube
     *
     */
    public function getMovieHash()
    {

        if (!isset($this->movieHash)) {
            $rtInfo = $this->getRtInfo();
            preg_match("@[a-f0-9]+$@", $rtInfo->movie->playerLink[0],$matches);
            $this->movieHash = $matches[0];
        }
        return $this->movieHash;

    }

    /*
     * Returns the HTML object to embed for this Rutube video
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

        return "<object width='{$defaultOptions['width']}' height='{$defaultOptions['height']}'>
                    <param name='movie' value='{$this->getEmbedUrl()}'></param>
                    <param name='wmode' value='window'></param>
                    <param name='allowFullScreen' value='true'></param>
                    <embed
                        src='{$this->getEmbedUrl()}'
                        type='application/x-shockwave-flash'
                        wmode='window'
                        width='{$defaultOptions['width']}' height='{$defaultOptions['height']}'
                        allowFullScreen='true'>
                    </embed>
                </object>";



    }

    /*
     * Returns the FLV url for this Rutube video
     *
     */
    public function getFLV()
    {
        $movieHash = $this->getMovieHash();
        return "http://bl.rutube.ru/{$movieHash}.iflv";
    }

    /*
     * Returns the Download url for this Rutube video
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
        return "Rutube";
    }

    /*
     * Loads the video information from Rutube API
     *
     */
    public function getRtInfo()
    {

        $videoId = (string) $this->getVideoId();
        $url = $this->rtXmlAPIUrl . "?rt_movie_id={$videoId}&rt_mode=movie";

        if (!isset($this->rtInfo)) {
            $content = file_get_contents($url);
            $this->rtInfo = simplexml_load_string($content);
        }
        return $this->rtInfo;

    }


    /*
     * Calculates the Video ID from an Rutube URL
     *
     * @param $url
     */
    public function getVideoID()
    {

        if (!isset($this->videoId)) {
            $path = parse_url($this->url,PHP_URL_PATH);
            preg_match("@(\d+)@", $path, $matches);
            $this->videoId = (int) $matches[1];
        }
        return $this->videoId;

    }
}