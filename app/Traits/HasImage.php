<?php

namespace App\Traits;

use App\Models\User;
use App\Utils\Constants;
use Image;

trait HasImage
{
    protected $imageAttribute = 'image';

    public function hasImage($attribute = null) {
        $fieldName = is_null($attribute) ? $this->imageAttribute : $attribute;
        return !!($this->$fieldName);
    }

    public function image($attribute = null) {
        $fieldName = is_null($attribute) ? $this->imageAttribute : $attribute;
        if ( ! $this->$fieldName) {
            // return url(Constants::NO_IMAGE_FILE_PATH);
        }
        return url( $this->$fieldName );
    }

    public function imageHtml($attribute = null, $asThumbnail = true) {
        if ( ! $this->hasImage($attribute) ) {
            return '---';
        }

        if ($asThumbnail) {
            return '<a target="_blank" href="' . $this->image($attribute) . '">
                <img alt="" src="' . $this->thumbnail($attribute) . '" class="img-responsive" />
            </a>';
        }

        return '<img alt="" src="' . $this->image($attribute) . '" class="img-responsive" />';
    }

    public function imageBase64($attribute = null) {
        $img = Image::make($this->image($attribute));
        return $img->encode('data-url');
    }

    public function thumbnail($attribute = null) {
        $fieldName = is_null($attribute) ? $this->imageAttribute : $attribute;
        if ( ! $this->$fieldName) {
            if (get_class($this) == User::class) {
                // return url(Constants::USER_NO_IMAGE_FILE_PATH);
            }
            // return url(Constants::NO_IMAGE_FILE_PATH);
        }
        $path_parts = pathinfo($this->$fieldName);
        return url( $path_parts['dirname'] . '/' . $path_parts['filename'] . '.thumb.' . $path_parts['extension']);
    }

}
