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
 * Wrapper class for Dailymotion videos.
 **/
class Dailymotion implements VideoInterface
{
    public $url;
    public $params = [];

    /**
     * @param $url
     * @param array $options
     */
    public function __construct($url, $params = [])
    {
        $this->url = $url;
        $this->params = $params;
        $this->getPage();
    }

    /*
     * Returns the page content for this video
     *
     * @return simplexmlobject The SimpleXML object for the web page XML
     */
    public function getPage()
    {
        if (!isset($this->page)) {
            $videoId = $this->getVideoID();
            $this->page = file_get_contents("http://www.dailymotion.com/video/{$videoId}");
        }

        return $this->page;
    }

    /*
     * Returns the title for this Dailymotion video
     *
     * @return string the title for this video
     */
    public function getTitle()
    {
        if (!isset($this->title)) {
            $this->title = $this->getByMetaProperty('og:title');
        }

        return $this->title;
    }

    /*
     * Returns the thumbnail for this Dailymotion video
     *
     * @return string the url to the thumbnail for this video
     */
    public function getThumbnail()
    {
        if (!isset($this->thumbnail)) {
            $this->thumbnail = $this->getByMetaProperty('og:image');
        }

        return $this->thumbnail;
    }

    /*
     * Returns the duration in secs for this Dailymotion video
     *
     * @return null this service doesn't allow to get duration of the video
     */
    public function getDuration()
    {
        if (!isset($this->thumbnail)) {
            $this->duration = $this->getByMetaProperty('video:duration');
        }

        return $this->duration;
    }

    /*
     * Returns the embed url for this Dailymotion video
     *
     * @return string the url to the embedurl of this video
     */
    public function getEmbedUrl()
    {
        if (!isset($this->embedUrl)) {
            $this->embedUrl = str_replace('?autoplay=1', '', $this->getByMetaProperty('og:video:url'));
        }

        return $this->embedUrl;
    }

    /*
     * Returns the HTML object to embed for this Dailymotion video
     *
     * @return string the html object to embed for this video
     */
    public function getEmbedHTML($options = [])
    {
        if (isset($this->embedHTML)) {
            return $this->embedHTML;
        }
        $defaultOptions = ['width' => 560, 'height' => 349];
        $options = array_merge($defaultOptions, $options);

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

        $this->embedHTML = "<iframe src='{$this->getEmbedUrl()}' "
            ."width='{$options['width']}' "
            ."height='{$options['height']}' frameborder='0' "
            ."title='{$this->getTitle()}' "
            ."webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>";

        return $this->embedHTML;
    }

    /*
     * Returns the FLV url for this Dailymotion video
     *
     * @return string the url for downloading the video in FLV format
     */
    public function getFLV()
    {
        return null;
    }

    /*
     * Returns the Download url for this Dailymotion video
     *
     * @return null not implemented for this video service
     */
    public function getDownloadUrl()
    {
        return;
    }

    /*
     * Returns the name of the Video service
     *
     * @return string the name of this video service
     */
    public function getService()
    {
        return 'Dailymotion';
    }

    /*
     * Calculates the Video ID from an Dailymotion URL
     *
     * @return string    the video ID for this video
     * @throws Exception if url doesn't seem to be a Dailymotion video url
     */
    public function getVideoID()
    {
        if (isset($this->videoId)) {
            return $this->videoId;
        }

        $urlParts = parse_url($this->url);
        $matches = preg_split('@/video/@', $urlParts['path']);
        if (count($matches) > 0) {
            $this->videoId = $matches[1];
        } else {
            throw new \Exception("This url doesn't seem to be a Dailymotion video url");
        }

        return $this->videoId;
    }

    /*
     * Extracts the meta property tag from the page
     *
     * @param string $name    The property name
     * @param string $default The default value to return if the property doesnt exists
     *
     * @return string    The value of the property
     */
    private function getByMetaProperty($name, $default = '')
    {
        $matched = preg_match_all('/property\=\"' . $name . '\" content=\"(?<part>.*)\"/i', $this->page,  $matches);

        return $matched ? (string) $matches['part'][0] : $default;
    }
    /*
     * Extracts the meta tag from the page
     *
     * @param string $name    The property name
     * @param string $default The default value to return if the property doesnt exists
     *
     * @return string    The value of the property
     */
    private function getByMetaName($name, $default = '')
    {
        $matched = preg_match_all('/name\=\"' . $name . '\" content=\"(?<part>.*)\"/i', $this->page,  $matches);

        return $matched ? (string) $matches['part'][0] : $default;
    }
}
