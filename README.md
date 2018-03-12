Panorama PHP
============

[![Build Status](https://travis-ci.org/frandieguez/panorama-php.svg?branch=master)](https://travis-ci.org/frandieguez/panorama-php)

What  is this!
--------------

With this wrapper class you can manage any video service in a uniformed and
unique way. You only need the URL from the video service you are going to use.

A quick example:

To include [this video](http://www.youtube.com/watch?v=HziGOzKOb9w&feature=player_embedded) in
[a post](http://www.retrincos.info/video/2011/04/27/2011042717512600207.html) you only need to know the
url of the video. With Panorama-PHP API you get this information:

        $video = new \Panorama\Video("http://www.youtube.com/watch?v=GPQnbtldFyo")
        $video.getTitle() => "paradon del portero"
        $video.getThumbnail() => "http://i4.ytimg.com/vi/GPQnbtldFyo/default.jpg"
        $video.getEmbedUrl() => "http://www.youtube.com/v/GPQnbtldFyo"
        $video.getEmbedHTML()(width, height) => "<object [...]</object>"
        $video.getFLV() => "http://...flv"
        # all together :)
        $video.getVideoDetails(width, height) => {
                                                'title' => ...,
                                                'thumbnail' => ...,
                                                'embed_url' => ...,
                                                'embed_html' => ...,
                                                'flv' => ...
                                              }


Install it!
-----------

1. Just put in one of your include_path folders, and make sure to use an
PSR-0-compatible autoloader.

Dependencies
------------
This library only depends on PHP 5.6, you have to use namespaces and some other goodies of 5.4 version.

Please __don't ask for PHP < 5.6 support__, you shouldn't use it. In the near future we will move to 7.0 as minimum version.

Use it!
-------

The idea is make it as simple as possible. For a URL video like <http://vimeo.com/1785993>:

        $video = new \Panorama\Video("http://vimeo.com/1785993")

Then you have methods to know information about the video in your application.

-   __getTitle:__ A method to know the title of the video of the service.

          $video.getTitle()
          => "Beached"

-   __getService:__ A method to know the name of the video provider service.

        $video.getService()
        => "Vimeo"

-   __getThumbnail:__ An image representation of the video. Each service has a different size, but... it works :)

          $video.getThumbnail()
          => "http://bc1.vimeo.com/vimeo/thumbs/143104745_640.jpg"

-   __getEmbedUrl:__ The url (with flashvars) of the video player.

          $video.getEmbedUrl()
          => "http://vimeo.com/moogaloop.swf?clip_id=1785993 [...] &show_portrait=1"

-   __getEmbedHTML(width, height):__ Uses the embed\_url to build an oembed string. The default width x height is 425 x 344, but we can specify a different one.

          $video.getEmbedHTML(400, 300)
          => "<object width='400' height='300'><param name='mo [...] 300'></embed></object>"

-   __getFLV:__ Gets the flv url. Not all the services has this option. Remember that
in some services the flv url expires and in their terms don't allow using the
flv without its player.

          $video.getFLV
          => "http://www.vimeo.com/moogaloop/play/clip:1785993/ [...] 8ee400/video.flv"

-   __getVideoDetails(width, height):__ All together :), returns all the previous elements
in a hash. Width and height can be specified to build the embed\_html.

          $video.getVideoDetails()
          => "array( [...] )"


Supported services
------------------

At this moment we support the following video services:

-   [Youtube](http://www.youtube.com/)
-   [Vimeo](http://vimeo.com/)
-   [Flickr (videos)](http://flickr.com/)
-   [Metacafe](http://metacafe.com/)
-   [Dailymotion](http://dailymotion.com/)
-   [Collegehumor](http://collegehumor.com/)
-   [Blip.tv](http://blip.tv/)
-   [Myspace](http://vids.myspace.com/)
-   [11870.com](http://11870.com/)
-   [Marca.tv](http://www.marca.tv/)
-   [Dalealplay](http://www.dalealplay.com/)
-   [RuTube](http://www.rutube.ru/)

Broken services
---------------

These services were included in this API but, due changes in their website, don't work
anymore. Any patch for fixing them are welcome. ;)

-   [Ted Talks](http://www.ted.com/talks/)
-   [Qik](http://qik.com/)
-   [MTV](http://www.mtvhive.com/)

If you detect new broken services by running the tests please let me know.

We are always open to incude new services.

Test it!
--------
Help us to mantain this library updated. Run our behaviour tests with behat to
give us feedback about what services don't work anymore.

For running tests:

1. Install composer in your system https://getcomposer.org/doc/00-intro.md
2. Install dependencies: composer install
3. Execute the tests: bin/behat features

Build Status
------------
[<img src="https://secure.travis-ci.org/frandieguez/panorama-php.png"/>](http://travis-ci.org/frandieguez/panorama-php)

And... what else?
-----------------
If you find a bug or want to suggest a new video service, please let us know in [a ticket](http://github.com/frandieguez/panorama-php/issues).

Thanks!!
