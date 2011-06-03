<?php

$steps->Given('/^The url (.+)$/', function($world, $url) {
    $world->video = new \Panorama\Video($url);
});

$steps->When('/^I get the (.+)$/', function($world, $method) {
    switch ($method) {
        case 'title':
            $world->result = $world->video->getTitle();
            break;
        
        case 'thumbnail':
            $world->result = $world->video->getThumbnail();
            break;
        
        case 'duration':
            $world->result = $world->video->getDuration();
            break;
        
        case 'download url':
            $world->result = $world->video->getDownloadUrl();
            break;
        
        case 'embed':
            $world->result = $world->video->getEmbedUrl();
            break;
        
        case 'embedHTML':
            $world->result = $world->video->getEmbedHTML(array());
            break;
        
        case 'service name':
            $world->result = $world->video->getService();
            break;
        
        case 'FLV url':
            $world->result = $world->video->getFLV();
        break;
        
        default:
            throw new Behat\Behat\Exception\Pending("not implemented");
        
    }
});

$steps->Then('/^The result should be "(.+)"$/', function($world, $result) {
    assertEquals($result, $world->result);
});

$steps->Then('/^The result should be:$/', function($world, $content) {
    $content = strtr($content, array("'''" => '"""'));
    //var_dump($content, $world->result);
    //die();
    assertEquals($content, $world->result);
});