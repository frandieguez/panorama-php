<?php
/**
 * This file is part of the Panorama package.
 *
 * (c)  Fran Dieguez <fran.dieguez@mabishu.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 **/
namespace Panorama\Video;

/**
 * Wrapper class for Youtube.
 **/
class Youtube implements VideoInterface
{
    public $url;
    public $params = [];

    /**
     * @param $url
     * @param array $options
     *
     * @throws \Exception
     */
    public function __construct($url, $params = [])
    {
        $this->url = $url;
        $this->params = $params;

        return $this;
    }

    /*
     * Returns the video ID from the video url
     *
     * @returns string, the Youtube ID of this video
     */
    public function getVideoId()
    {
        if (!isset($this->videoId)) {
            $this->videoId = $this->getUrlParam('v');
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
            $oembed = $this->getOEmbedInfo($this->url);

            $this->title = (string) $oembed->title;
        }

        return $this->title;
    }

    /*
     * Returs the object HTML with a specific width, height and options
     *
     * @param width,   the width of the final flash object
     * @param height,  the height of the final flash object
     * @param options, you can read more about the youtube player options
     *                 in  http://code.google.com/intl/en/apis/
     *                     youtube/player_parameters.html
     *                 Use them in options
     *                 (ex {:rel => 0, :color1 => '0x333333'})
     */
    public function getEmbedHTML($options = [])
    {
        $defaultOptions = ['width' => 560, 'height' => 349];
        $options        = array_merge($defaultOptions, $options);

        // convert options into
        $htmlOptions = '';
        if (count($options) > 0) {
            foreach ($options as $key => $value) {
                if (in_array($key, ['width', 'height'])) {
                    continue;
                }
                $htmlOptions .= '&'.$key.'='.$value;
            }
        }
        $embedUrl = $this->getEmbedUrl();

        // if this video is not embed
        return   "<iframe type='text/html' src='{$embedUrl}'"
            ." width='{$options['width']}' height='{$options['height']}'"
            ." frameborder='0' allowfullscreen='true'></iframe>";
    }

    /*
     * Returns the FLV url
     *
     * @returns string, the url to the video URL
     */
    public function getFLV()
    {
        return "";
    }

    /*
     * Returns the embed url of the video
     *
     * @returns string, the embed url of the video
     */
    public function getEmbedUrl()
    {
        $this->embedUrl = '';
        if (empty($this->embedUrl)) {
            $oembed = $this->getOEmbedInfo($this->url);

            $this->embedUrl = (string) $oembed->html;

            $matched = preg_match('@src="([^""]*)"@', $oembed->html, $matches);

            $this->embedUrl = $matches[1];
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
        return 'Youtube';
    }

    /*
     * Returns the url for downloading the flv video file
     *
     * @returns string, the url for downloading the flv video file
     */
    public function getDownloadUrl()
    {
        return "";
    }

    /*
     * Returns the duration in sec of the video
     *
     * @returns string, the duration in sec of the video
     */
    public function getDuration()
    {
        return 0;
    }

    /*
     * Returns the video Thumbnail
     *
     * @returns string, the video thumbnail url
     */
    public function getThumbnail()
    {
        if (!isset($this->thumbnail)) {
            $oembed = $this->getOEmbedInfo($this->url);

            $this->thumbnail = (string) $oembed->thumbnail_url;
        }

        return $this->thumbnail;
    }

    /**
     * Returns the value of the param given.
     *
     * @param string, the param to look for
     *
     * @return string, the value of the param
     */
    private function getUrlParam($param)
    {
        $queryParamsRAW = parse_url($this->url, PHP_URL_QUERY);
        preg_match('@v=([a-zA-Z0-9_-]*)@', $queryParamsRAW, $matches);

        return $matches[1];
    }

    /**
     * Returns the OEmbed information for a given Youtube video
     *
     * @return array the Oembed info array
     **/
    private function getOEmbedInfo($url = '')
    {
        if (isset($this->oembed)) {
            return $this->oembed;
        }

        $info = file_get_contents('https://www.youtube.com/oembed?url=' . urlencode($url) . '&format=json');

        $this->oembed = json_decode($info);

        return $this->oembed;
    }
}
