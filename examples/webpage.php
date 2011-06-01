<?php 
require("bootstrap.php");

$videos []= new \Panorama\Video("http://www.youtube.com/watch?v=uO3GYt47YQs&feature=topvideos_entertainment");
//$videos []= new \Panorama\Video("http://11870.com/pro/chic-basic-born/media/b606abfe");
$videos []= new \Panorama\Video("http://www.youtube.com/watch?v=5YXEcvaz3hI");
$videos []= new \Panorama\Video("http://vimeo.com/5362441");
$videos []= new \Panorama\Video("http://www.ted.com/index.php/talks/benjamin_wallace_on_the_price_of_happiness.html");
$videos []= new \Panorama\Video("http://rutube.ru/tracks/4436308.html?v=da5ede8f5aa5832e74b8afec8bd1818f");
//$videos []= new \Panorama\Video("http://qik.com/video/340982");
$videos []= new \Panorama\Video("http://vids.myspace.com/index.cfm?fuseaction=vids.individual&VideoID=27111431");
//$videos []= new \Panorama\Video("http://www.mtvhive.com/artist/florence_and_the_machine/videos/599614/dog_days_are_over_live");
$videos []= new \Panorama\Video("http://www.metacafe.com/watch/476621/experiments_with_the_myth_busters_with_diet_coke_and_mentos_dry/");
$videos []= new \Panorama\Video("http://www.marca.com/tv/?v=DN23wG8c1Rj");
?>
<html lang="en">
    <head>
        <style type="text/css">
            body {
                font-size:11px;
                font-family:Arial, Verdana;
                color:#666;
                max-width:800px;
            }
        </style>
    </head>
    <body>
        
        <?php foreach ($videos as $video) { ?>
            <h2>Video from <?php echo $video->getService(); ?>: <strong><?php echo $video->getTitle(); ?></strong></h2>
            <div>
                <?php echo $video->getEmbedHTML(array('version' => '3')); ?>
            </div>
        <?php } ?>
        
    </body>
</html>
