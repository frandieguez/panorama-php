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
 * Wrapper class for Youtube.
 *
 * @author Fran Diéguez <fran@openhost.es>
 *
 * @version \$Id\$
 *
 * @copyright OpenHost S.L., Mér Xuñ 01 15:58:58 2011
 **/
namespace Panorama\Video;

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
     * Returns the page contents of the url
     *
     */
    public function getPage()
    {
        if (!isset($this->page)) {
            $this->page = file_get_contents($this->url);
            if (!$this->page) {
                throw new \Exception('Video id not valid or found.', 1);
            }
        }

        return $this->page;
    }

    /*
     * Returns the title for this Ted video
     *
     */
    public function getTitle()
    {
        preg_match(
            '@<span id="altHeadline"  class="notranslate">(.*)</span>@',
            $this->getPage(),
            $matches
        );

        return trim($matches[1]);
    }

    /*
     * Returns the thumbnail for this Ted video
     *
     */
    public function getThumbnail()
    {
        if (!isset($this->thumbnail)) {
            $args = $this->getArgs();
            $this->thumbnail = $args['su'];
        }

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
        $flashvars = $this->getFlashVars();

        return "http://video.ted.com/assets/player/swf/EmbedPlayer.swf?{$flashvars}";
    }

    /*
     * Returns the HTML object to embed for this Ted video
     *
     */
    public function getEmbedHTML($options = [])
    {
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
        $embedUrl = $this->getEmbedUrl();

        return "<object width='{$options['width']}' "
            ."height='{$options['height']}'>\n"
            ."<param name='movie' value='{$embedUrl}'></param>\n"
            ."<param name='allowFullScreen' value='true'></param>\n"
            ."<param name='wmode' value='transparent'></param>\n"
            ."<param name='bgColor' value='#ffffff'></param>\n"
            ."<embed pluginspace='http://www.macromedia.com/go/getflashplayer\n"
            ."type='application/x-shockwave-flash'\n"
            ."wmode='transparent' allowFullScreen='true' bgColor='#ffffff'\n"
            ."src='{$embedUrl}'\n"
            ."width='{$options['width']}' "
            ."height='{$options['height']}'></embed>\n"
            .'</object>';
    }

    /*
     * Returns the flash vars for this video
     *
     */
    public function getFlashVars()
    {
        if (!isset($this->flashvars)) {
            $videoId = $this->getVideoID();
            $this->emb = file_get_contents(
                "http://www.ted.com/talks/embed/id/{$videoId}"
            );

            $split = preg_split(
                "@param\sname=\"flashvars\"\svalue=\"@",
                urldecode((string) $this->emb)
            );
            $split = preg_split('@"@', $split[1]);
            $this->flashvars = $split[0];
        }

        return $this->flashvars;
    }

    /*
     * Returns the arguments from url
     *
     */
    public function getArgs()
    {
        if (!isset($this->args)) {
            $parts = explode('&', $this->getFlashVars());
            $this->args = [];
            foreach ($parts as $part) {
                $elemParts = explode('=', $part);
                $args[$elemParts[0]] = $elemParts[1];
            }
            $this->args = $args;
        }

        return $this->args;
    }

    /*
     * Returns the FLV url for this Ted video
     *
     */
    public function getFLV()
    {
        if (!isset($this->FLV)) {
            $args = $this->getArgs();
            $this->FLV = (string) $args['vu'];
        }

        return $this->FLV;
    }

    /*
     * Returns the Download url for this Ted video
     *
     */
    public function getDownloadUrl()
    {
        if (!isset($this->downloadUrl)) {
            preg_match(
                '@<a href="(.*)">download the video</a>@',
                $this->getPage(),
                $matches
            );
            $this->downloadUrl = $matches[1];
        }

        return $this->downloadUrl;
    }

    /*
     * Returns the name of the Video service
     *
     */
    public function getService()
    {
        return 'Ted';
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
