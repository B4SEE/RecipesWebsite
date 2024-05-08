<?php
/**
 * This file contains functions related to file control operations.
 * It includes functions for recursively removing a directory and its contents,
 * creating an image resource from an image path, and cropping an image to the specified dimensions.
 */

/**
 * Recursively removes a directory and its contents.
 *
 * @param string $src The path to the directory to be removed.
 * @return void
 */
function rrmdir($src)
{
    $dir = opendir($src);
    while (false !== ($file = readdir($dir))) {
        if (($file != '.') && ($file != '..')) {
            $full = $src . '/' . $file;
            if (is_dir($full)) {
                rrmdir($full);
            } else {
                unlink($full);
            }
        }
    }
    closedir($dir);
    rmdir($src);
}

/**
 * Creates an image resource from the given image path.
 *
 * @param string $image_path The path of the image file.
 * @return resource|false The image resource on success, or false on failure.
 */
function createImageResource($image_path)
{
    $extension = strtolower(pathinfo($image_path, PATHINFO_EXTENSION));

    switch ($extension) {
        case 'jpg':
        case 'jpeg':
            $image = imagecreatefromjpeg($image_path);
            break;
        case 'png':
            $image = imagecreatefrompng($image_path);
            break;
        default:
            $image = false;
            break;
    }
    return $image;
}

/**
 * Crop an image to the specified dimensions.
 *
 * @param string $image_path The path to the image file.
 * @param int $thumb_width The desired width of the cropped image.
 * @param int $thumb_height The desired height of the cropped image.
 * @return string|false The path to the cropped image on success, or false on failure.
 */
function cropImage($image_path, $thumb_width, $thumb_height)
{
    $username = basename(dirname($image_path));
    $image = createImageResource($image_path);
    if ($image === false) {
        return false;
    }
    $image_width = imagesx($image);
    $image_height = imagesy($image);
    $original_aspect = $image_width / $image_height;
    $thumb_aspect = $thumb_width / $thumb_height;
    if ($original_aspect >= $thumb_aspect) {
        $new_height = $thumb_height;
        $new_width = $image_width / ($image_height / $thumb_height);
    } else {
        $new_width = $thumb_width;
        $new_height = $image_height / ($image_width / $thumb_width);
    }
    $thumb = imagecreatetruecolor($thumb_width, $thumb_height);
    imagecopyresampled(
        $thumb,
        $image,
        0 - ($new_width - $thumb_width) / 2,
        0 - ($new_height - $thumb_height) / 2,
        0,
        0,
        $new_width,
        $new_height,
        $image_width,
        $image_height
    );

    $originalName = pathinfo($image_path, PATHINFO_FILENAME);
    $extension = pathinfo($image_path, PATHINFO_EXTENSION);
    $new_image_path = 'uploads/' . $username . '/' . $originalName . '_cropped.' . $extension;

    imagejpeg($thumb, $new_image_path, 80);

    return $new_image_path;
}
?>