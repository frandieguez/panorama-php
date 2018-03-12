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
 * Wrapper class for Vimeo.
 **/
class Vimeo implements VideoInterface
{
    public $url;
    public $params = [];

    private $feed = null;

    /**
     * @param $url
     * @param array $options
     */
    public function __construct($url, $params = [])
    {
        $this->url = $url;
        $this->params = $params;

        // Retrieve video Id and fetch information
        $this->videoId = $this->getVideoID($this->url);
        $this->oEmbed  = $this->getOEmbed($this->url);
    }

    /*
     * Returns the feed that contains information of video
     *
     * @return the feed that contains the video information
     */
    public function getOEmbed($url = null)
    {
        if (empty($url)) {
            $url = $this->url;
        }

        if (!isset($this->oEmbed)) {
            $this->oEmbed = json_decode(
                file_get_contents('https://vimeo.com/api/oembed.json?url=' . $url)
            );
        }

        return $this->oEmbed;
    }

    /*
     * Returns the title for this Vimeo video
     *
     * @return string, the title for this Vimeo video
     */
    public function getTitle()
    {
        if (!isset($this->title)) {
            $this->title = (string) $this->getOEmbed()->title;
        }

        return $this->title;
    }

    /*
     * Returns the thumbnails for this Vimeo video
     *
     * @return string, the HTML object to embed for this Vimeo video
     */
    public function getThumbnail()
    {
        if (!isset($this->thumbnail)) {
            $this->thumbnail = $this->getOEmbed()->thumbnail_url;
        }

        return $this->thumbnail;
    }

    /*
     * Returns the duration in secs for this Vimeo video
     *
     */
    public function getDuration()
    {
        return 0;
    }

    /*
     * Returns the embed url for this Vimeo video
     *
     * @return string, the embed url for this Vimeo video
     */
    public function getEmbedUrl()
    {
        if (!isset($this->embedUrl)) {
            $this->embedUrl = 'https://player.vimeo.com/video/'.$this->getVideoID();
        }

        return $this->embedUrl;
    }

    /*
     * Returns the HTML object to embed for this Vimeo video
     *
     * @param mixed, options to modify the final HTML
     * @return string, the HTML object to embed for this Vimeo video
     */
    public function getEmbedHTML($options = [])
    {
        if (!isset($this->embedHTML)) {
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

            $this->embedHTML = sprintf(
                "<iframe src='%s' width='%s' height='%s' frameborder='0' title='%s' "
                . "webkitAllowFullScreen  mozallowfullscreen allowFullScreen></iframe>",
                $this->getEmbedUrl(),
                $options['width'],
                $options['height'],
                $this->getTitle()
            );
        }

        return $this->embedHTML;
    }

    /*
     * Returns the FLV url for this Vimeo video
     *
     * @returns string, the FLV url for this Vimeo video
     */
    public function getFLV()
    {
        return;
    }

    /*
     * Returns the Download url for this Vimeo video
     *
     * @returns string, the Download url for this Vimeo video
     */
    public function getDownloadUrl()
    {
        return;
    }

    /*
     * Returns the name of the Video service
     *
     * @returns string, the name of the Video service
     *
     */
    public function getService()
    {
        return 'Vimeo';
    }

    /*
     * Calculate the Video ID from an Vimeo URL
     *
     * @param $url
     * @return string,    the Video ID from an Vimeo URL
     * @throws Exception, if path is not valid
     */
    public function getVideoID($url = '')
    {
        if (!isset($this->videoId)) {
            try {
                $uri = parse_url($url);

                if (isset($uri['fragment'])) {
                    $this->videoId = $uri['fragment'];
                } elseif (isset($uri['path'])) {
                    $pathParts = preg_split('@/@', $uri['path']);
                    if (count($pathParts) > 0) {
                        $this->videoId = $pathParts[1];
                    } else {
                        throw \Exception("The path {$url} sems to be invalid");
                    }
                }
            } catch (Exception $e) {
                throw \Exception("The path {$url} sems to be invalid");
            }
        }

        return $this->videoId;
    }
}
