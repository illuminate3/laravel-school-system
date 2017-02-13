<?php

namespace App\Http\Controllers\Secure;

use App\Repositories\LoginHistoryRepository;
use App\Repositories\TeacherSubjectRepository;
use Datatables;
use Efriandika\LaravelSettings\Facades\Settings;
use Session;

class LoginHistoryController extends SecureController
{
    /**
     * @var LoginHistoryRepository
     */
    private $loginHistoryRepository;

    /**
     * DairyController constructor.
     * @param LoginHistoryRepository $loginHistoryRepository
     */
    public function __construct(LoginHistoryRepository $loginHistoryRepository)
    {
        parent::__construct();
        $this->loginHistoryRepository = $loginHistoryRepository;
        view()->share('type', 'login_history');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $title = trans('login_history.login_history');
        return view('login_history.index', compact('title'));
    }

    public function data()
    {
        $login_histories = $this->loginHistoryRepository->getAll()
            ->orderBy('created_at', 'desc')
            ->with('user')->get()
            ->map(function ($login_history) {
                return [
                    'id' => $login_history->id,
                    'user' => isset($login_history->user) ? $login_history->user->full_name : "",
                    'ip_address' => $login_history->ip_address,
                    'date_time' => $login_history->created_at->format(Settings::get('date_format') . ' ' . Settings::get('time_format')),
                ];
            });
        return Datatables::of($login_histories->toBase()->unique())
            ->remove_column('id')
            ->make();
    }
}
