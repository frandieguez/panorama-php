<?php

//url
$url = 'http://www.imdb.com/title/tt0367882/';

//get the page content
$imdb_content = getData($url);

//parse for product name
$name = getMatch('/<title>(.*)<\/title>/isU', $imdb_content);
$director = strip_tags(getMatch('/<h5[^>]*>Director:<\/h5>(.*)<\/div>/isU', $imdb_content));
$plot = getMatch('/<h5[^>]*>Plot:<\/h5>(.*)<\/div>/isU', $imdb_content);
$release_date = getMatch('/<h5[^>]*>Release Date:<\/h5>(.*)<\/div>/isU', $imdb_content);
$mpaa = getMatch('/<a href="\/mpaa">MPAA<\/a>:<\/h5>(.*)<\/div>/isU', $imdb_content);
$run_time = getMatch('/Runtime:<\/h5>(.*)<\/div>/isU', $imdb_content);

//build content
$content .= '<h2>Film</h2><p>'.$name.'</p>';
$content .= '<h2>Director</h2><p>'.$director.'</p>';
$content .= '<h2>Plot</h2><p>'.substr($plot, 0, strpos($plot, '<a')).'</p>';
$content .= '<h2>Release Date</h2><p>'.substr($release_date, 0, strpos($release_date, '<a')).'</p>';
$content .= '<h2>MPAA</h2><p>'.$mpaa.'</p>';
$content .= '<h2>Run Time</h2><p>'.$run_time.'</p>';
$content .= '<h2>Full Details</h2><p><a href="'.$url.'" rel="nofollow">'.$url.'</a></p>';

echo $content;

//gets the match content
function getMatch($regex, $content)
{
    preg_match($regex, $content, $matches);

    return $matches[1];
}

//gets the data from a URL
function getData($url)
{
    $ch = curl_init();
    $timeout = 5;
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    $data = curl_exec($ch);
    curl_close($ch);

    return $data;
}
