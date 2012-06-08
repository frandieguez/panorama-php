<?php
//url
$url = 'http://www.imdb.com/title/tt0367882/';

//get the page content
$imdb_content = get_data($url);

//parse for product name
$name = get_match('/<title>(.*)<\/title>/isU',$imdb_content);
$director = strip_tags(get_match('/<h5[^>]*>Director:<\/h5>(.*)<\/div>/isU',$imdb_content));
$plot = get_match('/<h5[^>]*>Plot:<\/h5>(.*)<\/div>/isU',$imdb_content);
$release_date = get_match('/<h5[^>]*>Release Date:<\/h5>(.*)<\/div>/isU',$imdb_content);
$mpaa = get_match('/<a href="\/mpaa">MPAA<\/a>:<\/h5>(.*)<\/div>/isU',$imdb_content);
$run_time = get_match('/Runtime:<\/h5>(.*)<\/div>/isU',$imdb_content);

//build content
$content.= '<h2>Film</h2><p>'.$name.'</p>';
$content.= '<h2>Director</h2><p>'.$director.'</p>';
$content.= '<h2>Plot</h2><p>'.substr($plot,0,strpos($plot,'<a')).'</p>';
$content.= '<h2>Release Date</h2><p>'.substr($release_date,0,strpos($release_date,'<a')).'</p>';
$content.= '<h2>MPAA</h2><p>'.$mpaa.'</p>';
$content.= '<h2>Run Time</h2><p>'.$run_time.'</p>';
$content.= '<h2>Full Details</h2><p><a href="'.$url.'" rel="nofollow">'.$url.'</a></p>';

echo $content;

//gets the match content
function get_match($regex,$content)
{
  preg_match($regex,$content,$matches);
  return $matches[1];
}

//gets the data from a URL
function get_data($url)
{
  $ch = curl_init();
  $timeout = 5;
  curl_setopt($ch,CURLOPT_URL,$url);
  curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
  curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
  $data = curl_exec($ch);
  curl_close($ch);
  return $data;
}