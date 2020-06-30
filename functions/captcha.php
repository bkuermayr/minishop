<?php
session_start();
create_image();

function create_image()
{
    // Generating Random Code
    $md5_hash = md5(rand(0,999));
    $captcha = substr($md5_hash, 15,5);

    $_SESSION['captcha'] = $captcha;

    $width = 200;
    $height = 50;

    $image = ImageCreate($width,$height);

    // Colours
    $colors= array(
        imagecolorallocate($image, 255, 255, 255),
        imagecolorallocate($image, 0, 0, 0),
        imagecolorallocate($image, 0, 255, 0),
        imagecolorallocate($image, 139, 69, 19),
        imagecolorallocate($image, 255, 69, 0),
        imagecolorallocate($image, 204, 204, 204),
    );
    $i1 = rand(0,5);
    $back= $colors[$i1];
    // Making Background
    imagefill($image, 0, 0,$back);

    do {
        $i2 = rand(0,5);
    } while ($i2 == $i1);

    $fontcolor= $colors[$i2];
        
    // Carving Text into the image
    // Set the enviroment variable for GD
    putenv('GDFONTPATH=' . realpath('.'));
    // Name the font to be used (note the lack of the .ttf extension)
    $font = 'font';
    imagettftext($image, 25, 10, 45, 45, $fontcolor, $font, $captcha);

    // Informing Browser there is a jpeg image file is coming
    header("Content-Type: image/jpeg");

    //Converting Image into JPEG
    imagejpeg($image);
    // Clearing Cache
    imagedestroy($image);
}