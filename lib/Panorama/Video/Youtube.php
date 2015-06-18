<?php
/**
 * Wrapper class for Youtube
 *
 * @author Maksim Korobitsyn <kor-mac@ya.ru>
 * @package Panorama\Video
 **/
namespace Panorama\Video;

class Youtube  implements VideoInterface
{

    public $apiKey = ''; // v3 api key. See more in https://console.developers.google.com/project/{project-id}/apiui/credential
    public $part = ['player','snippet', 'contentDetails'];

    /*
     * __construct()
     * @param $url
     */
    public function __construct($url)
    {
        $this->url = $url;

        if (empty($this->apiKey))
        {
            throw new \Exception('Not set API Key in Panorama\Video\Youtube.php.', 1);
        }

        if (!($this->videoId = $this->getVideoID()))
        {
            throw new \Exception("Video ID not valid.", 1);
        }
        $this->getFeed();

        return $this;
    }

    private function getDataFromUrl($url)
    {
        $c = curl_init($url);

        curl_setopt($c, CURLOPT_FAILONERROR, true);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($c, CURLOPT_TIMEOUT, 15);

        $data = curl_exec($c);
        if (curl_error($c))
        {
            $data = false;
        }

        curl_close($c);
        return $data;
    }

    /*
     * Returns the feed that contains information of video
     *
     */
    public function getFeed()
    {
        if (!isset($this->feed)) {
            $this->feed = null;
            $parts = implode(',',$this->part);
            $url = "https://www.googleapis.com/youtube/v3/videos?part={$parts}&id={$this->videoId}&key={$this->apiKey}";

            $data = $this->getDataFromUrl($url);
            if (!$data) {
                throw new \Exception('Video Id not valid.');
            }
            $data = (array)json_decode($data);

            if (!empty($data))
            {
                $item = $data['items'][0];
                $feed = new \stdClass();

                $feed->title          = $item->snippet->title;
                $feed->description    = $item->snippet->description;
                $feed->thumbnails     = $item->snippet->thumbnails;
                $feed->embedHtml      = $item->player->embedHtml;
                $feed->embedUrl       = $this->parseEmbedUrl($item->player->embedHtml);

                $this->feed = $feed;
            }
        }

        return $this->feed;
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
        return $this->feed->title;
    }

    /*
     * Returns the descrition for this video
     *
     * @returns string, the description of this video
     */
    public function getDescription()
    {
        return $this->feed->description;
    }

    /*
     * Returs the object HTML with a specific width, height and options
     *
     * @param width,   the width of the final flash object
     * @param height,  the height of the final flash object
     * @param options, you can read more about the youtube player options
     *                 in  http://code.google.com/intl/en/apis/
     *                     youtube/player_parameters.html
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
            foreach ($options as $key => $value) {
                $htmlOptions .= " " . $key . "='" . $value . "'";
            }
        }
        $embedUrl = $this->getEmbedUrl();

        return "<iframe {$htmlOptions} src='{$embedUrl}' frameborder='0' allowfullscreen></iframe>";
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
        return $this->feed->embedUrl;
    }

    /*
     * Returns the embed url of the video
     *
     * @returns string, the embed url of the video
     */
    private function parseEmbedUrl($html)
    {
        preg_match("@src=\"([a-zA-Z0-9_./]*)\"@", $html, $matches);

        return $matches[1];
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
        return $this->feed->embedUrl;
    }

    /*
     * Returns the duration in sec of the video
     *
     * @returns string, the duration in sec of the video
     */
    public function getDuration()
    {
        //TODO: fixed small hacks
        return 0;
    }

    /*
     * Returns the video Thumbnails
     *
     * @returns mixed, the video thumbnails
     */
    public function getThumbnails()
    {
        return $this->feed->thumbnails;
    }

    /*
     * Returns the video Thumbnail
     *
     * @returns string, the video thumbnail url
     */
    public function getThumbnail()
    {
        return $this->feed->thumbnails->standart->url;
    }

    /*
     * Returns the video tags
     *
     * @returns mixed, a list of tags for this video
     */
    public function getTags()
    {
        //TODO: fixed small hacks
        return '';
    }

    /*
     * Returns the watch url for the video
     *
     * @returns string, the url for watching this video
     */
    public function getWatchUrl()
    {
        //TODO: fixed small hacks
        return $this->url;
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

        if (!$matches)
        {
            preg_match("@embed/([a-zA-Z0-9_-]*)@", parse_url($this->url, PHP_URL_PATH), $matches);
        }

        return $matches[1];
    }
}
