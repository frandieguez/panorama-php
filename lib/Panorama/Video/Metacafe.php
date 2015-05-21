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
 * Wrapper class for Metacafe videos.
 *
 * @author Fran Diéguez <fran@openhost.es>
 **/
namespace Panorama\Video;

class Metacafe implements VideoInterface
{
    public $url;
    public $params = [];

    /**
     * @param $url
     * @param array $params
     */
    public function __construct($url, $params = [])
    {
        $this->url = $url;
        $this->params = $params;

        $this->args = $this->getArgs();
        $this->videoId = $this->getVideoId();

        $pos = stripos('yt-', $this->args[0]);

        $this->youtubed = ($pos == false) ? false : true;

        // TODO move to another (dev) branch
        // I can't find a video that comes from Youtube so this snippet is
        // untestable for now
        if ($this->youtubed) {
            $output = preg_split('yt-', $this->args[1]);
            $this->object = new Youtube("http://www.youtube.com/watch?v={$output[1]}");
        }
    }

    /*
     * Return the video id
     *
     */
    public function getVideoId()
    {
        if (!isset($this->videoId)) {
            $args = $this->getArgs();
            $this->videoId = $args[0];
        }

        return $this->videoId;
    }

    /*
     * Returns the args from video url
     *
     */
    public function getArgs()
    {
        if (!isset($this->args)) {
            $uri = parse_url($this->url);
            $path = $uri['path'];
            $this->args = null;

            if (isset($path) && count(preg_split('@/@', $path)) > 1) {
                $args = preg_split('@/@', $path);
                $this->args = array($args[2], $args[3]);
            }
        }

        return $this->args;
    }

    /*
     * Returns the title for this Metacafe video
     *
     */
    public function getTitle()
    {
        if (!isset($this->title)) {
            if ($this->youtubed) {
                $this->title = $this->object->getTitle();
            } else {
                $this->title = ucfirst(str_replace('_', ' ', $this->args[1]));
            }
        }

        return $this->title;
    }

    /*
     * Returns the thumbnail for this Metacafe video
     *
     */
    public function getThumbnail()
    {
        if (!isset($this->thumbnail)) {
            $args = $this->getArgs();
            $this->thumbnail = "http://www.metacafe.com/thumb/{$args[0]}.jpg";
        }

        return $this->thumbnail;
    }

    /*
     * Returns the duration in secs for this Metacafe video
     *
     */
    public function getDuration()
    {
        return;
    }

    /*
     * Returns the embed url for this Metacafe video
     *
     */
    public function getEmbedUrl()
    {
        if (!isset($this->embedUrl)) {
            $params = implode('/', $this->getArgs());
            $this->embedUrl = "http://www.metacafe.com/fplayer/{$params}.swf";
        }

        return $this->embedUrl;
    }

    /*
     * Returns the HTML object to embed for this Metacafe video
     *
     */
    public function getEmbedHTML($params = [])
    {
        if (!isset($this->embedHTML)) {
            $defaultOptions = ['width' => 560, 'height' => 349];
            $params = array_merge($defaultOptions, $params);

            // convert options into
            $htmlOptions = '';
            if (count($params) > 0) {
                foreach ($params as $key => $value) {
                    if (in_array($key, ['width', 'height'])) {
                        continue;
                    }
                    $htmlOptions .= '&'.$key.'='.$value;
                }
            }

            $this->embedHTML =
                "<embed\n"
                ." src='{$this->getEmbedUrl()}'\n"
                ." width='{$params['width']}'"
                ." height='{$params['height']}'\n"
                ." wmode='transparent'\n"
                ." pluginspage='http://www.macromedia.com/go/getflashplayer'\n"
                ." type='application/x-shockwave-flash'>\n"
                .'</embed>';
        }

        return $this->embedHTML;
    }

    /*
     * Returns the FLV url for this Metacafe video
     *
     */
    public function getFLV()
    {
        return '';
        if (!isset($this->FLV)) {
            // Translate ruby code
            $finalUrl = urldecode(self::getFinalRedirect($this->getEmbedUrl()));

            // Problem this info is not available
            preg_match('@key":"(.*)"}@', $finalUrl, $params);
            $key = $params[1];

            preg_match('@mediaURL":"(.*)",@', $finalUrl, $params);
            $mediaUrl = preg_replace("/\\\/", '', $params[1]);

            $this->FLV = "{$mediaUrl}?__gdk__={$key}";
        }

        return $this->FLV;
    }

    /*
     * Returns the Download url for this Metacafe video
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
        return 'Metacafe';
    }

    /**
     * getRedirectUrl()
     * Gets the address that the provided URL redirects to,
     * or false if there's no redirect.
     *
     * @param string $url
     *
     * @return string
     */
    public static function getRedirectUrl($url)
    {
        $redirect_url = null;

        $url_parts = @parse_url($url);
        if (!$url_parts) {
            return false;
        }
        if (!isset($url_parts['host'])) {
            return false; //can't process relative URLs
        }
        if (!isset($url_parts['path'])) {
            $url_parts['path'] = '/';
        }

        $sock = fsockopen(
            $url_parts['host'],
            (isset($url_parts['port']) ? (int) $url_parts['port'] : 80),
            $errno,
            $errstr,
            30
        );
        if (!$sock) {
            return false;
        }

        $request = 'HEAD '.$url_parts['path'].(isset($url_parts['query']) ? '?'.$url_parts['query'] : '')." HTTP/1.1\r\n";
        $request .= 'Host: '.$url_parts['host']."\r\n";
        $request .= "Connection: Close\r\n\r\n";
        fwrite($sock, $request);
        $response = '';
        while (!feof($sock)) {
            $response .= fread($sock, 8192);
        }
        fclose($sock);

        if (preg_match('/^Location: (.+?)$/m', $response, $matches)) {
            if (substr($matches[1], 0, 1) == '/') {
                return $url_parts['scheme'].'://'.$url_parts['host'].trim($matches[1]);
            } else {
                return trim($matches[1]);
            }
        } else {
            return false;
        }
    }

    /**
     * getAllRedirects()
     * Follows and collects all redirects, in order, for the given URL.
     *
     * @param string $url
     *
     * @return array
     */
    private static function getAllRedirects($url)
    {
        $redirects = [];
        while ($newurl = self::getRedirectUrl($url)) {
            if (in_array($newurl, $redirects)) {
                break;
            }
            $redirects[] = $newurl;
            $url = $newurl;
        }

        return $redirects;
    }

    /**
     * getFinalRedirect()
     * Gets the address that the URL ultimately leads to.
     * Returns $url itself if it isn't a redirect.
     *
     * @param string $url
     *
     * @return string
     */
    private static function getFinalRedirect($url)
    {
        $redirects = self::getAllRedirects($url);
        if (count($redirects) > 0) {
            return array_pop($redirects);
        } else {
            return $url;
        }
    }
}
