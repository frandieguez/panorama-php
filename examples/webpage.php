<?php 
require("bootstrap.php");

$videos []= new \Panorama\Video("http://11870.com/pro/la-cabana-argentina/videos/25f8deec");
$videos []= new \Panorama\Video("http://www.dailymotion.com/visited-week/lang/es/video/x7u5kn_parkour-dayyy_sport");
$videos []= new \Panorama\Video("http://www.dalealplay.com/informaciondecontenido.php?con=80280");
// Falta FLICKR
$videos []= new \Panorama\Video("http://www.metacafe.com/watch/476621/experiments_with_the_myth_busters_with_diet_coke_and_mentos_dry/");
$videos []= new \Panorama\Video("http://www.marca.com/tv/?v=DN23wG8c1Rj");
//$videos []= new \Panorama\Video("http://www.mtvhive.com/artist/florence_and_the_machine/videos/599614/dog_days_are_over_live");
$videos []= new \Panorama\Video("http://vids.myspace.com/index.cfm?fuseaction=vids.individual&VideoID=27111431");
//$videos []= new \Panorama\Video("http://qik.com/video/340982");
$videos []= new \Panorama\Video("http://rutube.ru/tracks/4436308.html?v=da5ede8f5aa5832e74b8afec8bd1818f");
$videos []= new \Panorama\Video("http://www.ted.com/index.php/talks/benjamin_wallace_on_the_price_of_happiness.html");
$videos []= new \Panorama\Video("http://vimeo.com/5362441");
$videos []= new \Panorama\Video("http://www.youtube.com/watch?v=uO3GYt47YQs&feature=topvideos_entertainment");
apc_clear_cache();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"  dir="ltr">
<head>
	<title>Panorama-PHP Video API examples</title>
	<meta name="description" content="" />
	<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Droid+Serif" />
    <style type="text/css">
    
        /*  all media  */
        @media all
        {
            /* global */
            * 							{ margin:0; padding:0; } html { overflow-y:scroll; }
            body						{ font-family:'lucida grande',tahoma,verdana,arial,sans-serif; font-size:62.5%; color:#222; }
    
            /*	layout */
            .center			{ width:1000px; margin:0 auto; }
                #page			{  }
                #header		{ height:50px; background:url(assets/header.gif) 0 bottom repeat-x #fcfcfc; position:relative; }
                    a#header-logo	{ position:absolute; top:7px; left:0; text-indent:-99999px; width:32px; height:25px; display:block; background:url(ttp://www.mabishu.com/wp-content/themes/mabishu-v3/images/logo.png) 0 0 no-repeat; }
                    #header-title 	{ font-weight:normal; font-family:"Droid Serif",Cambria,Georgia,Palatino,"Palatino Linotype",Myriad Pro,Serif; font-size:2em; }
                        #header-title a	{ color:#000; text-decoration:none; position:absolute; top:10px; left:40px; }
                        
            #content	{ background:#fff; padding:10px 0 10px 0; }
                #content-left 	{ width:900px; margin:0 20px 0 0; float:left; }
                    #content-right a	{ float:left; padding-right:10px; display:block; width:125px; height:125px; }
    
            #footer		{ background:#eee; border-top:1px solid #ccc; padding:10px 0; }
                        #footer1, #footer2, #footer3 { width:300px; float:left; margin:0 30px 0 0; }
                        #footer3 { width:330px; margin-right:0; }
            
            /* tags */
            abbr						{ border-bottom:1px dotted #ccc; cursor:help; }
            blockquote					{ background:#eee; margin:0 20px; padding:10px 20px; }
            code						{ font-family:'Consolas', 'Monaco', 'Bitstream Vera Sans Mono', 'Courier New', Courier, monospace !important; }
            h1							{ font-size:4.3em; margin:0 0 20px 0; }
            h2							{ font-size:2.8em; margin-bottom: 10px; }
                h1, h2, h3, h6			{ font-weight:normal; font-family:"Droid Serif",Cambria,Georgia,Palatino,"Palatino Linotype","Myriad Pro",Serif; }
            h3, h6						{ font-size:2em; }
            h6							{ padding:0 0 5px 0; }
            label,select,input[type='submit'],.point { cursor:pointer; }
            li							{  }
            li,p						{ line-height:19px; margin-top:5px; }
            ol, ul						{ padding:0 0 10px 35px; }
            p							{ margin:5px 0 14px 0; font-size:1.2em; line-height:1.8em; }
            textarea,input[type='text'], input[type='email'], input[type='password']	{ border:1px solid #ccc; padding:5px; font-size:120%; font-family:'lucida grande',tahoma,verdana,arial,sans-serif; }
            
            /* stuff */
            .clear 						{ clear:both; }
            .exhead						{ background:#e8f0f6; border-top:1px solid #fff; color:#000; padding:10px 10px; font-size:120%; }
                .exhead a				{ color:#6D84B4; }
            .intro						{ background:#ffd987; font-style:italic; padding:5px 10px; margin-bottom:20px; }
            .relative					{ position:relative; }
            
            /* links */
            a								{ color:#3b5998; }
            a:link, a:visited			{ text-decoration:underline; }
            a:hover, a:active			{ text-decoration:none; }
            a img							{ border:0; }
            pre                         { background: #eee; padding:20px; font-size: 11px; margin:30px 0px; overflow-x:scroll; }
            .flash-object                { text-align:center; width:100%; }
            hr                          { height:1px !important; border:none; border-bottom:1px solid #ccc; margin-bottom:15px; }
            
        }
        
        
    </style>
<script type="text/javascript">
window.onload = function() {
	var paras = document.getElementById('content').getElementsByTagName('p');
	if(paras.length) {
		paras[0].className = paras[0].className + ' intro';
	}
};
</script></head>
<body>

    <!-- HEADER -->
    <div id="header">
        <div class="center relative">
            <a href="/" id="header-logo">Mabishu Studio</a>
            <div id="header-title">
                <a href="/">Mabishu Studio blog</a>
            </div>
        </div>
    </div>

    <div class="exhead">
        <div class="center">
            <strong>Example Page for: Panorama-PHP Video API</strong> .
        </div>
    </div>
    
    <div id="content">
        <div class="center">
        
            <div id="content-left">
                
                <h1 style="margin-top:20px;">Panorama-PHP Video API</h1>	
                <p>Scroll to see all the available Video API.</p>
        
                <?php foreach ($videos as $video) { ?>
                    <h2>
                        <small>Video from <?php echo $video->getService(); ?>:</small><br />
                        <?php echo $video->getTitle(); ?>
                    </h2>
                    <div>
                        <div class="flash-object">
                            <?php echo $video->getEmbedHTML(array('version' => '3')); ?>
                        </div>
                        <pre><code><strong>URL:</strong>: <?php
						echo $video->url."\n";
                        foreach ($video->getVideoDetails() as $key => $value ) {
                            $key = ucfirst($key);
                            $value = htmlentities($value);
                            echo "<strong>{$key}</strong>: {$value}\n";
                        } ?></code></pre>
                    </div>
					
                    <hr/>
                    
                <?php } ?>
            
            </div>
            <div class="clear"></div>
        </div>
    </div>
    
    <div class="exhead">
        <strong>&lt;&lt;Go to author page:</strong> <a href="http://www.mabishu.com">Mabishu.com &copy;</a>
    </div>
    
    <?php // print_r(apc_cache_info()); ?>
    
</body>
</html>
