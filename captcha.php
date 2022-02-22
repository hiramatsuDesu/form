<?php
session_start();

header("Content-type: image/jpeg");
$image=imagecreate(120,40);
$background_color=imagecolorallocate($image, 153, 255, 204);
$text_color=imagecolorallocate($image, 0, 77, 38);
imagestring($image, 4, 20, 10, $_SESSION['captcha'], $text_color);
imagejpeg($image);
?>