<?php

namespace App\Utils;

use App\Exceptions\ValidationAjaxException;
use Error;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

/**
 * ValidationHelper Class
 *
 * This class can used for validate incoming request with include default error message in indonesia.
 *
 * @copyright  2021 Ihza
 * @license
 * @version     1.0
 * @link
 * @since      Class available since Release 1.0
 */
class ValidationHelper
{
    private $messages = [
        'required' => 'Kolom :attribute harus diisi.',
        'image' => ':attribute harus berupa gambar.'
    ];

    /**
     * Validate incoming request
     *
     * @param Illuminate\Http\Request   $request  Just pass your request here
     * @param array $rules pass the rules of your input here
     * @param array $messages you can add your custom error message here
     * @param array $attributes you can custom your input name here
     *
     * @throws None
     * @author Ihza
     * @return Illuminate\Support\Facades\Validator you can use fails() method to check is input not expected with the $rules
     */
    public static function validate($request, $rules, $messages = [], $attributes = [])
    {
        $validator = Validator::make($request->all(), $rules, array_merge((new static)->messages, $messages), $attributes);
        if ($validator->fails()) {
            if ($request->header('ajax') == "1" || $request->expectsJson() || $request->ajax() || strpos($request->header('Content-Type'), 'application/json') !== false) {
                throw new ValidationAjaxException($validator);
            } else {
                throw new ValidationException($validator);
            }
        }
        return $validator;
    }


    /**
     * Redirect to current page with error message and old input
     *
     * @param Illuminate\Support\Facades\Validator   $validator  return data from validate method above
     *
     * @throws None
     * @author Ihza
     * @return null Redirect to current page with error message and old input
     */
    public static function validationError($validator)
    {
        return back()
            ->withErrors($validator)
            ->withInput();
    }


    public static function validateWithoutAutoRedirect($request, $rules, $messages = [], $attributes = [])
    {
        $validator = Validator::make($request->all(), $rules, array_merge((new static)->messages, $messages), $attributes);
        return $validator;
    }

    public static function ajaxValidationError($validator, $response = [], $withMessage = false)
    {
        if ($response != []) {
            if ($withMessage)
                $response = array_merge($response, [
                    "message" => $validator->messages()->first()
                ]);
        } else {
            $response = [
                "message" => $validator->messages()->first()
            ];
        }
        return response()->json($response);
    }
}
