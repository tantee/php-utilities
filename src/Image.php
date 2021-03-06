<?php

namespace TaNteE\PhpUtilities;

class Image
{
    public static function scaleBlobImage($imageBlob, $max_width, $max_height)
    {
        list($width, $height, $image_type) = getimagesizefromstring($imageBlob);
        $src = imagecreatefromstring($imageBlob);

        $x_ratio = $max_width / $width;
        $y_ratio = $max_height / $height;

        if (($width <= $max_width) && ($height <= $max_height)) {
            $tn_width = $width;
            $tn_height = $height;
        } elseif (($x_ratio * $height) < $max_height) {
            $tn_height = ceil($x_ratio * $height);
            $tn_width = $max_width;
        } else {
            $tn_width = ceil($y_ratio * $width);
            $tn_height = $max_height;
        }

        $tmp = imagecreatetruecolor($tn_width, $tn_height);

        /* Check if this image is PNG or GIF, then set if Transparent*/
        if (($image_type == 1) or ($image_type == 3)) {
            imagealphablending($tmp, false);
            imagesavealpha($tmp, true);
            $transparent = imagecolorallocatealpha($tmp, 255, 255, 255, 127);
            imagefilledrectangle($tmp, 0, 0, $tn_width, $tn_height, $transparent);
        }
        imagecopyresampled($tmp, $src, 0, 0, 0, 0, $tn_width, $tn_height, $width, $height);

        /*
        * imageXXX() only has two options, save as a file, or send to the browser.
        * It does not provide you the oppurtunity to manipulate the final GIF/JPG/PNG file stream
        * So I start the output buffering, use imageXXX() to output the data stream to the browser,
        * get the contents of the stream, and use clean to silently discard the buffered contents.
        */
        ob_start();

        switch ($image_type) {
            case 1: imagegif($tmp);

break;
            case 2: imagejpeg($tmp, null, 100);

break; // best quality
            case 3: imagepng($tmp, null, 0);

break; // no compression
            default: echo '';

break;
        }

        $final_image = ob_get_contents();

        ob_end_clean();

        return $final_image;
    }
}
