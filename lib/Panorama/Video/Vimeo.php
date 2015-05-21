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
 * Wrapper class for Vimeo.
 *
 * @author Fran Diéguez <fran@openhost.es>
 *
 * @version \$Id\$
 *
 * @copyright OpenHost S.L., Mér Xuñ 01 15:58:58 2011
 **/
namespace Panorama\Video;

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
        $this->getFeed();
    }

    /*
     * Returns the feed that contains information of video
     *
     */
    public function getFeed()
    {
        if (!isset($this->feed)) {
            $videoId = $this->getVideoID();

            $document = file_get_contents(
                'http://vimeo.com/api/v2/video/'.$videoId.'.php'
            );
            if (!$document) {
                throw new \Exception('Video Id not valid.');
            }
            $information = unserialize($document);
            $this->feed  = $information[0];
        }

        return $this->feed;
    }

    /*
     * Sets the feed that contains information of video,
     * usefull for using mocking objects
     *
     * @param $feed,
     */
    public function setFeed($feed)
    {
        $this->feed = $feed;
    }

    /*
     * Returns the title for this Vimeo video
     *
     * @return string, the title for this Vimeo video
     */
    public function getTitle()
    {
        if (!isset($this->title)) {
            $this->title = (string) $this->feed['title'];
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
            $this->thumbnail = (string) $this->feed['thumbnail_large'];
        }

        return $this->thumbnail;
    }

    /*
     * Returns the duration in secs for this Vimeo video
     *
     */
    public function getDuration()
    {
        if (!isset($this->duration)) {
            $this->duration = (string) $this->feed['duration'];
        }

        return $this->duration;
    }

    /*
     * Returns the embed url for this Vimeo video
     *
     * @return string, the embed url for this Vimeo video
     */
    public function getEmbedUrl()
    {
        if (!isset($this->embedUrl)) {
            $this->embedUrl = 'http://player.vimeo.com/video/'.$this->getVideoID();
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

            $this->embedHTML = '<iframe src="'.$this->getEmbedUrl()
                .'" width="'.$options['width']
                .'" height="'.$options['height'].'" '
                .'frameborder="0" webkitAllowFullScreen '
                .'mozallowfullscreen allowFullScreen>'
                .'</iframe>';
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
        if (!isset($this->FLV)) {
            $this->FLV = 'http://player.vimeo.com/video/'.$this->getVideoID();
        }

        return $this->FLV;
    }

    /*
     * Returns the Download url for this Vimeo video
     *
     * @returns string, the Download url for this Vimeo video
     */
    public function getDownloadUrl()
    {
        return $this->getFLV();
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
