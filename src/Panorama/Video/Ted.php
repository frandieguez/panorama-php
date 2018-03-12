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
class Ted implements VideoInterface
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

        $path = parse_url($url, PHP_URL_PATH);
        if (!preg_match('@talks@', $path)) {
            throw new \Exception(
                "The url '{$this->url}' is not a valid Ted talk url"
            );
        }
    }

    /*
     * Returns the title for this Ted video
     *
     */
    public function getTitle()
    {
        if (isset($this->title)) {
            return $this->title;
        }

        $this->title = $this->getOEmbed()->title;

        return $this->title;
    }

    /*
     * Returns the thumbnail for this Ted video
     *
     */
    public function getThumbnail()
    {
        if (isset($this->thumbnail)) {
            return $this->thumbnail;
        }

        $this->thumbnail = $this->getOEmbed()->thumbnail_url;

        return $this->thumbnail;
    }

    /*
     * Returns the duration in secs for this Ted video
     *
     */
    public function getDuration()
    {
        return;
    }

    /*
     * Returns the embed url for this Ted video
     *
     */
    public function getEmbedUrl()
    {
        $this->embedUrl = '';
        if (empty($this->embedUrl)) {
            $oembed = $this->getOEmbed($this->url);

            $this->embedUrl = (string) $oembed->html;

            $matched = preg_match('@src="([^""]*)"@', $oembed->html, $matches);

            $this->embedUrl = $matches[1];
        }

        return $this->embedUrl;
    }

    /*
     * Returns the HTML object to embed for this Ted video
     *
     */
    public function getEmbedHTML($options = [])
    {
        $defaultOptions = ['width' => 560, 'height' => 349];
        $options = array_merge($defaultOptions, $options);

        if (isset($this->embedHTML)) {
            return $this->embedHTML;
        }

        $this->embedHTML = sprintf(
            "<iframe src='%s' width='%s' height='%s' frameborder='0' scrolling='no' "
            . "webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>",
            $this->getEmbedUrl(),
            $options['width'],
            $options['height']
        );

        return $this->embedHTML;
    }

    /*
     * Returns the FLV url for this Ted video
     *
     */
    public function getFLV()
    {
        return;
    }

    /*
     * Returns the Download url for this Ted video
     *
     */
    public function getDownloadUrl()
    {
        return;
    }

    /*
     * Returns the name of the Video service
     *
     */
    public function getService()
    {
        return 'Ted';
    }

    /**
     * undocumented function
     *
     * @return void
     * @author
     **/
    public function getOEmbed()
    {
        if (isset($this->oEmbed)) {
            return $this->oEmbed;
        }

        $this->oEmbed = json_decode(
            file_get_contents('https://www.ted.com/services/v1/oembed.json?url='. $this->url)
        );

        return $this->oEmbed;
    }

    /*
     * Calculate the Video ID from an Ted URL
     *
     * @param $url
     */
    public function getVideoID()
    {
        if (!isset($this->videoId)) {
            preg_match(
                "@/talks/subtitles/id/(\d*)/lang/@",
                $this->getPage(),
                $matches
            );
            $this->videoId = (int) $matches[1];
        }

        return $this->videoId;
    }
}
