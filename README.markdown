Panorama PHP
============

What  is this!
--------------

This is the wrapper class to manage video services in a standarized way. It is an easy way to obtain a few basics about a video only through its url.

A quick example:

To include [this video](http://www.youtube.com/watch?v=GPQnbtldFyo) in [this post](http://unvlog.com/blat/2008/3/10/otro-pelotazo) we need to know its title, the correct way to embed it and its thumbnail url. With this plugin we have an easy access to this data:

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
        
With this Class we have an unique way to manage multiple services :)


Install it!
-----------

1. Install it as a gem:

        gem "acts_as_unvlogable"

Dependencies
------------
This library depends on

1.  [Zend Gdata](http://framework.zend.com/download/gdata) for access the Youtube API.
2. Obviosly PHP 5.3, we make use of namespaces and some other goodies of 5.3 version.

Please __don't as for PHP < 5.3 support__, you should not be using PHP 5.2 at all.

Use it!
-------

The idea is make it as simple as possible. For a given video URL as <http://vimeo.com/1785993>:

        $video = new \Panorama\Video("http://vimeo.com/1785993")

Then we have methods to know the 'basics' for use this video on your application.

-   __getTitle:__ A method to know the title of the video on the service.
  
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

-   __getFLV:__ Gets the flv url. In this edition we implement this method in all the services, but is possible that we can't get the flv in some scenarios. Remember that in some services the flv url expires and in most of their terms don't allow use the flv without its player.

          $video.getFLV
          => "http://www.vimeo.com/moogaloop/play/clip:1785993/ [...] 8ee400/video.flv"

-   __getVideoDetails(width, height):__ All together :), returns all the previous elements in a hash. Width and height can be specified to build the embed\_html.

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
-   [Ted Talks](http://www.ted.com/talks/)
-   [11870.com](http://11870.com/)
-   [Marca.tv](http://www.marca.tv/)
-   [Dalealplay](http://www.dalealplay.com/)
-   [RuTube](http://www.rutube.ru/)

Broken services
---------------

These services were implemented but due to changes in the website they don't work anymore. Any patch for fixing them would be great ;)

-   [Qik](http://qik.com/)
-   [MTV](http://www.mtvhive.com/)

You can detect new broken services when running the tests.

We are always open to incude new services.

And... what else?
-----------------
If you find a bug or want to suggest a new video service, please tell it to us in [a ticket](http://github.com/frandieguez/panorama-php/issues).

Thanks!!
