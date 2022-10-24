<?php

namespace App\Utils;


/**
 * Upload Image and Resize (if needed)
 *
 * This class can used for uploading image dan resize the size (optional) with keep the aspec ratio.
 *
 * @copyright  2021 Ihza
 * @license
 * @version     1.0
 * @link
 * @since      Class available since Release 1.0
 */
class ImageUploadResizeHelper
{
    /**
     * Upload the image
     *
     * @param Illuminate\Http\Request   $imageRequestObject  the image object from request object
     * @param integer $requiredSize the max size for uploaded image. if don't want to resize the image, just give this false
     * @param string $path where the image will be placed
     * @param string $name the name of uploaded image
     * @param boolean $generateThumbnail condition to generate the thumbnail or not
     *
     * @throws None
     * @author Ihza
     * @return array contain full path the uploaded image
     */
    public static function upload($imageRequestObject, $requiredSize, $path, $name, $generateThumbnail = true)
    {
        $image = Image::make($imageRequestObject);
        $ext = $image->getClientOriginalExtension();
        $width = $image->width();
        $height = $image->height();

        // Check if image resize is required or not
        if ($requiredSize >= $width && $requiredSize >= $height || $requiredSize == false) {
            $image->save(public_path($path) . $name . '.' . $ext);
            $data['resize'] = false;
        } else {

            $newWidth = 0;
            $newHeight = 0;

            $aspectRatio = $width / $height;
            if ($aspectRatio >= 1.0) {
                $newWidth = $requiredSize;
                $newHeight = $requiredSize / $aspectRatio;
            } else {
                $newWidth = $requiredSize * $aspectRatio;
                $newHeight = $requiredSize;
            }


            $image->resize($newWidth, $newHeight);
            $image->save(public_path($path) . '/' . $name . '.' . $ext);
            $data['resize'] = true;
        }
        if ($generateThumbnail) {
            $filename_thumb = $name . '.thumb.' . $ext;
            $relativePath_thumb = $path . $filename_thumb;
            $fullPath_thumb = public_path($relativePath_thumb);

            $image->fit(200, 200)->save($fullPath_thumb);
        }
        $data['status'] =  true;
        $data['full_path'] = $path  . $name . '.' . $ext;

        return $data;
    }
}
