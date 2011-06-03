<?php 
require_once('bootstrap.php');

//$video = stdClass();
//$video = new \Panorama\Video("http://www.youtube.com/watch?v=4buJaPd4Wuc&feature=topvideos_entertainment");
//$video = new \Panorama\Video("http://11870.com/pro/chic-basic-born/media/b606abfe");
//$video = new \Panorama\Video("http://www.youtube.com/watch?v=5YXEcvaz3hI");
//$video = new \Panorama\Video("http://vimeo.com/5362441");
//$video = new \Panorama\Video("http://www.ted.com/index.php/talks/benjamin_wallace_on_the_price_of_happiness.html");
//$video = new \Panorama\Video("http://rutube.ru/tracks/4436308.html?v=da5ede8f5aa5832e74b8afec8bd1818f");
//$video = new \Panorama\Video("http://qik.com/video/340982");
//$video = new \Panorama\Video("http://vids.myspace.com/index.cfm?fuseaction=vids.individual&VideoID=27111431");
//$video = new \Panorama\Video("http://www.mtvhive.com/artist/florence_and_the_machine/videos/599614/dog_days_are_over_live");
//$video = new \Panorama\Video("http://www.metacafe.com/watch/476621/experiments_with_the_myth_busters_with_diet_coke_and_mentos_dry/");
$video = new \Panorama\Video("http://www.marca.com/tv/?v=DN23wG8c1Rj");
//$video = new \Panorama\Video("http://www.dalealplay.com/informaciondecontenido.php?con=80280");
//$video = new \Panorama\Video("http://11870.com/pro/chic-basic-born/media/b606abfe");
//$video = new \Panorama\Video("http://www.dailymotion.com/visited-week/lang/es/video/x7u5kn_parkour-dayyy_sport");


var_dump(
         $video->getTitle(),
         $video->getThumbnail(),
         $video->getVideoId(),
         $video->getDuration(),
         $video->getEmbedUrl(),
         $video->getVideoID(),
         $video->getEmbedHTML(array('version' => '3')),
         $video->getVideoId(),
         $video->getFLV(),
         $video->getVideoDetails(),
         $video->getDownloadUrl()
         
         );
die();
