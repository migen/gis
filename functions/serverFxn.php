<?php


function getUrl(){

$url=$_SERVER['REQUEST_URI'];
$url=ltrim($url,'/');
$url=ltrim($url,DOMAIN);
$url=ltrim($url,'/');

return $url;


}	/* fxn */
