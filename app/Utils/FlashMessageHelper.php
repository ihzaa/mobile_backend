<?php

namespace App\Utils;

class FlashMessageHelper
{
    /**
    data example :
    WITH TITLE
    $data = [
         "bg" => "success",
         "icon" => "plus",
         "title" => "Berhasilll!",
         "text" => "Berhasil menambahkan data!"
             ]
    ---- OR ----
    WITHOUT TITLE
    $data = [
         "class" => "alert-success",
         "icon" => "plus",
         "text" => "Berhasil menambahkan data!"
             ]
     */
    public static function alert($data)
    {
        session()->flash('alert', '1');
        if (isset($data['icon']))
            session()->flash('alert-icon', $data['icon']);
        if (isset($data['title']))
            session()->flash('alert-title', $data['title']);
        if (isset($data['text']))
            session()->flash('alert-text', $data['text']);
    }

    public static function bootstrapSuccessAlert($text, $title = "")
    {
        session()->flash('alert', '1');
        session()->flash('alert-icon', 'success');
        session()->flash('alert-title', $title);
        session()->flash('alert-text', $text);
    }

    public static function bootstrapDangerAlert($text, $title = "")
    {
        session()->flash('alert', '1');
        session()->flash('alert-icon', 'error');
        session()->flash('alert-title', $title);
        session()->flash('alert-text', $text);
    }

    public static function swal($message)
    {
        session()->flash('alert', "1");
        session()->flash('alert-icon', isset($message['icon']) ? $message['icon'] : '');
        session()->flash('alert-title',  isset($message['title']) ? $message['title'] : '');
        session()->flash('alert-text',  isset($message['text']) ? $message['text'] : '');
    }
}
