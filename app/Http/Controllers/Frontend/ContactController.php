<?php

namespace App\Http\Controllers\Frontend;

use Efriandika\LaravelSettings\Facades\Settings;
use Illuminate\Support\Facades\Mail;

class ContactController extends FrontendController
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $title = trans('frontend.contact');
        return view('contact', compact('title'));
    }

    public function contact()
    {
        Mail::send('emails.contact', array(
            'name' => $request->name,
            'content' => $request->message,
            'email' => $request->email,
        ), function ($message) use($request)
        {
            $message->from($request->email);
            $message->to(Settings::get('email'))
                ->subject(Lang::get('frontend.contact'));
        });
        return redirect('contact')->with('success', trans('frontend.contact_message'));
    }
}
