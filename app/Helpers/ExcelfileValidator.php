<?php

namespace App\Helpers;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class ExcelfileValidator
{
    public static function validate($request)
    {
        $validator = Validator::make(
            [
                'file' => $request->file('file'),
                'extension' => strtolower($request->file('file')->getClientOriginalExtension()),
            ],
            [
                'file' => 'required',
                'extension' => 'required|in:csv',
            ]
        );
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        return true;
    }
}

?>
