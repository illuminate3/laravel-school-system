<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Page;
use App\Models\School;
use App\Models\Slider;
use App\Repositories\UserRepository;
use Efriandika\LaravelSettings\Facades\Settings;

class PageController extends FrontendController
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        parent::__construct();
        $this->userRepository = $userRepository;
    }

    public function show($page_slug)
    {
        $page = Page::whereSlug($page_slug)->first();
        if ($page==null) {
            $page = Page::orderBy('order')->first();
            if (!isset($page->slug)) {
                return redirect('signin');
            }
        }
        $title = $page->title;
        $sliders = Slider::orderBy('position')->get();
        return view('page', compact('page', 'title', 'pages','sliders'));
    }

    public function aboutSchoolPage()
    {
        $title = Settings::get('about_school_page_title');
        $introduction = Settings::get('about_school_page_introduction');
        $schools = School::all();
        return view('about_pages/about_school', compact('title', 'introduction', 'schools'));
    }

    public function aboutTeachersPage()
    {
        $title = Settings::get('about_teachers_page_title');
        $introduction = Settings::get('about_teachers_page_introduction');
        $teachers = $this->userRepository->getUsersForRole('teacher');
        return view('about_pages/about_teacher', compact('title', 'introduction', 'teachers'));
    }
}
