<?php
ini_set ("memory_limit", "100M");

$tempbig = imagecreatefromjpeg("mypicture.jpg"); 
$bigsize = getimagesize("mypicture.jpg");



$bigwidth = $bigsize[0];
$bigheight = $bigsize[1];

$tempsmall = imagecreate(40, 40); 


imagecopyresized($tempsmall, $tempbig, 0, 0, 0, 0, 40, 40, $bigwidth, $bigheight); 

agejpeg($tempsmall, 'thmypicture.jpg', 95); 
ImageDestroy($tempbig); 
ImageDestroy($tempsmall); 


?> 