<?php

namespace App\Utils;

use Carbon\Carbon;

class ChangeDateFormatHelper
{
    public static function formatDate($inputDate, $inputFormat = "d/m/Y", $outputFormat = "Y-m-d")
    {
        return Carbon::createFromFormat($inputFormat, $inputDate)->format($outputFormat);
    }
}
