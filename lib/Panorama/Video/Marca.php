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
 * Wrapper class for Marca TV videos.
 *
 * @author Fran Diéguez <fran@openhost.es>
 *
 * @version \$Id\$
 *
 * @copyright OpenHost S.L., Mér Xuñ 01 15:58:58 2011
 **/
namespace Panorama\Video;

class Marca implements VideoInterface
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
        $this->videoId = $this->getVideoID();

        $sub1 = substr($this->videoId, 0, 1);
        $sub2 = substr($this->videoId, 1, 1);
        $sub3 = substr($this->videoId, 2, 100);

        $doc = file_get_contents(
            "http://estaticos.marca.com/consolamultimedia/marcaTV/elementos/{$sub1}/{$sub2}/{$sub3}.xml"
        );
        $this->feed = simplexml_load_string($doc);
    }

    /*
     * Returns the title for this Marca video
     *
     */
    public function getTitle()
    {
        if (!isset($this->title)) {
            $title = $this->feed->xpath('//titulo');
            $this->title = (string) $title[0];
        }

        return $this->title;
    }

    /*
     * Returns the thumbnail for this Marca video
     *
     */
    public function getThumbnail()
    {
        if (!isset($this->thumbnail)) {
            $tmb = $this->feed->xpath('//foto');

            return (string) $tmb[0];
        }

        return $this->thumbnail;
    }

    /*
     * Returns the duration in secs for this Marca video
     *
     */
    public function getDuration()
    {
        return;
    }

    /*
     * Returns the embed url for this Marca video
     *
     */
    public function getEmbedUrl()
    {
        return 'http://www.marca.com/componentes/flash/embed.swf'
            ."?ba=0&cvol=1&bt=1&lg=1&vID={$this->videoId}&ba=1";
    }

    /*
     * Returns the HTML object to embed for this Marca video
     *
     */
    public function getEmbedHTML($params = [])
    {
        $defaultOptions = array(
          'width' => 560,
          'height' => 349,
        );

        $params = array_merge($defaultOptions, $params);
        unset($params['width']);
        unset($params['height']);

        // convert options into
        $htmlOptions = '';
        if (count($params) > 0) {
            foreach ($params as $key => $value) {
                $htmlOptions .= '&'.$key.'='.$value;
            }
        }

        $flashvars = 'ba=1&amp;cvol=1&amp;bt=1&amp;lg=0&amp;'
                    ."width={$defaultOptions['width']}&amp;height={$defaultOptions['height']}"
                    ."&amp;vID={$this->getVideoId()}";

        return   "<object width='{$defaultOptions['width']}' "
                ."height='{$defaultOptions['height']}' \n"
                ."classid='clsid:d27cdb6e-ae6d-11cf-96b8-444553540000'\n"
                ."codebase='http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0'>\n"
                ."<param name='movie' value='http://estaticos.marca.com/multimedia/reproductores/newPlayer.swf'>\n"
                ."<param name='quality' value='high'>\n"
                ."<param name='allowFullScreen' value='true'>\n"
                ."<param name='wmode' value='transparent'>\n"
                ."<param name='FlashVars' value='{$flashvars}'>\n"
                ."<embed\n"
                ."width='{$defaultOptions['width']}' height='{$defaultOptions['height']}'\n"
                ."src='http://estaticos03.marca.com/multimedia/reproductores/newPlayer.swf'\n"
                ."quality='high'\n"
                ."flashvars='ba=1&amp;cvol=1&amp;bt=1&amp;lg=0&amp;vID={$this->getVideoId()}' allowfullscreen='true'\n"
                ."type='application/x-shockwave-flash'\n"
                ."pluginspage='http://www.macromedia.com/go/getflashplayer'\n"
                ."wmode='transparent'>\n"
                .'</object>';
    }

    /*
     * Returns the FLV url for this Marca video
     *
     */
    public function getFLV()
    {
        if (!isset($this->FLV)) {
            $FLV = $this->feed->xpath('//media');
            $this->FLV = (string) $FLV[0];
        }

        return $this->FLV;
    }

    /*
     * Returns the Download url for this Marca video
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
        return 'Marca';
    }

    /*
     * Calculates the Video ID from an Marca URL
     *
     * @param $url
     */
    public function getVideoID()
    {
        if (!isset($this->videoId)) {
            $path = parse_url($this->url, PHP_URL_QUERY);
            preg_match("@v=(\w*)@", $path, $matches);
            if (count($matches) > 1) {
                $this->videoId = $matches[1];
            } else {
                throw new \Exception('This ');
            }
        }

        return $this->videoId;
    }
}
