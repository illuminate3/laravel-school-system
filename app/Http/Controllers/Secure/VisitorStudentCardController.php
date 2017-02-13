<?php

namespace App\Http\Controllers\Secure;

use App\Http\Requests;
use App\Models\School;
use App\Models\SchoolAdmin;
use App\Models\User;
use App\Models\Visitor;
use App\Repositories\UserRepository;
use Datatables;
use Efriandika\LaravelSettings\Facades\Settings;
use Illuminate\Support\Facades\App;
use Sentinel;
use App\Http\Requests\Secure\SchoolAdminRequest;

class VisitorStudentCardController extends SecureController
{
    private $begin_html = '';

    public function __construct()
    {
        parent::__construct();

        $this->begin_html = '<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
                <html>
                    <head>
                        <style>
                        table {
                            border-collapse: collapse;
                             width:100%;
                        }

                        table, td, th {
                            border: 1px solid #000000;
                            text-align:center;
                            vertical-align:middle;
                        }
                        </style>
                    </head>
                ';
    }

    /**
     * Display the specified resource.
     *
     * @param  User $visitor
     * @return Response
     */
    public function visitor(User $user)
    {
        $data = $this->begin_html . '<title>' . trans('visitor_student_card.visitor_card') . '</title>
        <body background="' . url('uploads/visitor_card/' . Settings::get('visitor_card_background')) . '">';
        $data .= '<table><tr><td>
                <h1>' . trans('visitor_student_card.visitor_card') . ' - ' . Settings::get('name') . '</h1>';
        $data .= '<h2>' . $user->full_name . '</h2>';
        $data .= '<h2>' . $user->email . '</h2>';
        $data .= '<h2>' . trans('visitor_student_card.visitor_no') . ': ' . $user->visitor->last()->visitor_no . '</h2>';
        $data .= '</td></tr></table></body></html>';
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML($data);
        return $pdf->stream();
    }

    /**
     * Display the specified resource.
     *
     * @param  User $visitor
     * @return Response
     */
    public function student(User $user)
    {
        $school = $user->student->last()->school;
        $data = $this->begin_html . '<title>' . trans('visitor_student_card.student_card') . '</title>
                <body background="' . url($school->student_card_background) . '">';
        $data .= '<table><tr><td>
                <h1>' . trans('visitor_student_card.student_card') . ' - ' . $school->title . '</h1>';
        $data .= '<h2>' . $user->full_name . '</h2>';
        $data .= '<h2>' . $user->email . '</h2>';
        $data .= '<h2>' . trans('visitor_student_card.student_no') . ': ' . $user->student->last()->student_no . '</h2></td><td>';
        $data .= '<img src="' . url($user->picture) . '"></td></tr></table>';
        $data .= '</body></html>';
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML($data);
        return $pdf->stream();
    }

}
