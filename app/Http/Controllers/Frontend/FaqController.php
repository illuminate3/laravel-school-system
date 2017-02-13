<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Faq;
use App\Models\FaqCategory;
use App\Models\Page;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class FaqController extends FrontendController
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
        $faqs = Faq::all();
        $faq_categories = FaqCategory::all();
        $title = trans('frontend.faq');

        return view('faq', compact('faqs','faq_categories','title'));
    }
}
