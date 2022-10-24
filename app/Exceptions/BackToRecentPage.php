<?php

namespace App\Exceptions;

use App\Utils\FlashMessageHelper;
use Exception;

class BackToRecentPage extends Exception
{

    public function __construct($message, $title = "Kesalahan")
    {
        $this->message = $message;
        $this->title = $title;
    }

    public function render()
    {
        FlashMessageHelper::bootstrapDangerAlert($this->message, $this->title);
        return back();
    }
}
