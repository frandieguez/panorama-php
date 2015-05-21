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
 * Wrapper class for Youtube
 *
 * @author Fran Diéguez <fran@openhost.es>
 * @package Panorama\Video
 **/
namespace Panorama\Video;

class Youtube  implements VideoInterface
{
    public $url;
    public $params = [];

    /**
     * @param $url
     * @param array $options
     * @throws \Exception
     */
    public function __construct($url, $params = [])
    {
        $this->url    = $url;
        $this->params = $params;

        if (!array_key_exists('youtube', $params)
            && !array_key_exists('api_key', $params['youtube'])
            && empty($params['youtube']['api_key'])
        ) {
            throw new \Exception("Missing Youtube configuration.");
        }

        $this->params = $params['youtube'];

        if (!($this->videoId = $this->getvideoId())) {
            throw new \Exception("Video ID not valid.", 1);
        }
        $this->getFeed();

        return $this;
    }

    /*
     * Returns the feed that contains information of video
     *
     */
    public function getFeed()
    {
        if (!isset($this->feed)) {
            $videoId = $this->getVideoID();
            $apikey  = $this->params['api_key'];

            // Fetch and decode information from the API
            $data = file_get_contents(
                "https://www.googleapis.com/youtube/v3/videos?key=".$apikey
                ."&id=".$videoId."&part=snippet,contentDetails,statistics,player"
            );
            $videoObj = @json_decode($data);

            if (empty($videoObj->items)) {
                throw new \Exception('Video Id not valid.');
            }
        }

        return $videoObj->items[0];
    }

    /*
     * Returns the video ID from the video url
     *
     * @returns string, the Youtube ID of this video
     */
    public function getVideoId()
    {
        if (!isset($this->videoId)) {
            $this->videoId =  $this->getUrlParam('v');
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
            $this->title = (string) $this->getFeed()->snippet->title;
        }

        return $this->title;
    }

    /*
     * Returns the descrition for this video
     *
     * @returns string, the description of this video
     */
    public function getDescription()
    {
        if (!isset($this->description)) {
            $this->description = (string) $this->getFeed()->snippet->description;
        }

        return $this->description;
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
        $options = array_merge($defaultOptions, $options);

        // convert options into
        $htmlOptions = "";
        if (count($options) > 0) {
            foreach ($options as $key => $value) {
                if (in_array($key, ['width', 'height'])) {
                    continue;
                }
                $htmlOptions .= "&" . $key . "=" . $value;
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
        if (!isset($this->FLV)) {
            $this->FLV =  $this->getEmbedUrl();
        }

        return $this->FLV;

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
            $this->embedUrl = 'http://www.youtube.com/embed/'.$this->getVideoID();
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
        return "Youtube";
    }

    /*
     * Returns the url for downloading the flv video file
     *
     * @returns string, the url for downloading the flv video file
     */
    public function getDownloadUrl()
    {
        if (!isset($this->downloadUrl)) {
            $this->downloadUrl = $this->getEmbedUrl();
        }

        return $this->downloadUrl;
    }

    /*
     * Returns the duration in sec of the video
     *
     * @returns string, the duration in sec of the video
     */
    public function getDuration()
    {
        if (!isset($this->duration)) {
            $this->duration = new \DateTime('@0'); // Unix epoch

            $this->duration->add(
                new \DateInterval(
                    $this->getFeed()->contentDetails->duration
                )
            );
        }

        return $this->duration->format('H:i:s');
    }

    /*
     * Returns the video Thumbnails
     *
     * @returns mixed, the video thumbnails
     */
    public function getThumbnails()
    {
        if (!isset($this->thumbnails)) {
            $this->thumbnails = $this->getFeed()->snippet->thumbnails;
        }

        return $this->thumbnails;
    }

    /*
     * Returns the video Thumbnail
     *
     * @returns string, the video thumbnail url
     */
    public function getThumbnail()
    {
        if (!isset($this->thumbnail)) {
            $thumbnailArray = $this->getThumbnails();

            if (isset($thumbnailArray->standard->url)) {
                $this->thumbnail = $thumbnailArray->standard->url;
            } elseif (isset($thumbnailArray->high->url)) {
                $this->thumbnail = $thumbnailArray->high->url;
            } elseif (isset($thumbnailArray->medium->url)) {
                $this->thumbnail = $thumbnailArray->medium->url;
            } else {
                $this->thumbnail = $thumbnailArray->default->url;
            }
        }

        return $this->thumbnail;
    }

    /*
     * Returns the video tags
     *
     * @returns mixed, a list of tags for this video
     */
    public function getTags()
    {
        if (!isset($this->tags)) {
            $this->tags =  $this->getFeed()->snippet->title;
        }

        return $this->tags;
    }

    /*
     * Returns the watch url for the video
     *
     * @returns string, the url for watching this video
     */
    public function getWatchUrl()
    {
        if (!isset($this->watchUrl)) {
            $this->watchUrl = $this->url;
        }

        return $this->watchUrl;
    }

    /**
     * Returns the value of the param given
     *
     * @param string, the param to look for
     * @return string, the value of the param
     */
    private function getUrlParam($param)
    {
        $queryParamsRAW = parse_url($this->url, PHP_URL_QUERY);
        preg_match("@v=([a-zA-Z0-9_-]*)@", $queryParamsRAW, $matches);

        return $matches[1];
    }
}
