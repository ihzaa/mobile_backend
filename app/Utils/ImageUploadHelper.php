<?php

namespace App\Utils;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Image;
use Symfony\Component\HttpFoundation\File\File;
use File as JustFile;

class ImageUploadHelper {

    public static function processImg(&$obj, $model_key, $folder_name, $photo_name, $input_key = null) {
        if ( is_null($input_key) ) {
            $input_key = $model_key;
        }
        if (request()->hasFile($input_key)) {
            $imageFile = request()->file($input_key);
            $result = ImageUploadHelper::upload(
                $imageFile,
                'uploads/' . $folder_name. '/',
                $photo_name . '_' . date('YmdHis')
            );
            if ($result['success']) {
                $obj->$model_key = $result['image_relative_path'];
            }
        }
    }

    public static function processImgBase64(&$obj, $model_key, $folder_name, $photo_name, $input_base64) {
        // https://stackoverflow.com/a/58512459/2695256
        // decode the base64 file
        $fileData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $input_base64));

        // save it to temporary dir first.
        $tmpFilePath = sys_get_temp_dir() . '/' . Str::uuid()->toString();
        file_put_contents($tmpFilePath, $fileData);

        // this just to help us get file info.
        $tmpFile = new File($tmpFilePath);

        $imageFile = new UploadedFile(
            $tmpFile->getPathname(),
            $tmpFile->getFilename(),
            $tmpFile->getMimeType(),
            0,
            true // Mark it as test, since the file isn't from real HTTP POST.
        );

        $result = ImageUploadHelper::upload(
            $imageFile,
            'uploads/' . $folder_name. '/',
            $photo_name . '_' . date('YmdHis')
        );
        if ($result['success']) {
            $obj->$model_key = $result['image_relative_path'];
        }
    }

    public static function upload($image, $path, $name, $generateThumbnail = true, $thumbWidth = 200, $thumbHeight = 200) {
        $ext = $image->getClientOriginalExtension() ?: 'jpg';

        if (!JustFile::exists($path)) {
            JustFile::makeDirectory($path, 0775, true, true);
        }
        
        $filename = $name . '.' . $ext;
        $relativePath = $path . $filename;
        $fullPath = public_path( $relativePath );

        // resize and save
        $imageObject = Image::make($image);
        $imageObject->save($fullPath);

        $result = [
            'success' => true,
            'image_filename' => $filename,
            'image_relative_path' => $relativePath,
            'image_full_path' => $fullPath,
        ];

        if ($generateThumbnail) {
            $filename_thumb = $name . '.thumb.' . $ext;
            $relativePath_thumb = $path . $filename_thumb;
            $fullPath_thumb = public_path( $relativePath_thumb );

            $imageObject->fit($thumbWidth, $thumbHeight)->save($fullPath_thumb);

            $result['thumb_filename'] = $filename;
            $result['thumb_relative_path'] = $relativePath;
            $result['thumb_full_path'] = $fullPath;
        }

        return $result;
    }
    
    public static function resizeAndUpload($imageRequestObject, $requiredSize, $path, $name, $generateThumbnail = true)
    {
        if (!JustFile::exists($path)) {
            // Storage::makeDirectory($path, 0775, true, true);
            JustFile::makeDirectory($path, 0775, true, true);
        }
        
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
