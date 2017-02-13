<?php

namespace App\Http\Controllers\Secure;

use App\Http\Requests;
use App\Models\School;
use App\Models\SchoolAdmin;
use App\Models\User;
use App\Models\Visitor;
use App\Repositories\UserRepository;
use Datatables;
use Sentinel;
use App\Http\Requests\Secure\SchoolAdminRequest;

class VisitorController extends SecureController
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * TeacherController constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        parent::__construct();

        $this->userRepository = $userRepository;

        $this->middleware('authorized:visitor.show', ['only' => ['index', 'data']]);
        $this->middleware('authorized:visitor.create', ['only' => ['create', 'store']]);
        $this->middleware('authorized:visitor.edit', ['only' => ['update', 'edit']]);
        $this->middleware('authorized:visitor.delete', ['only' => ['delete', 'destroy']]);

        view()->share('type', 'visitor');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $title = trans('visitor.visitor');
        return view('visitor.index', compact('title'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show(User $visitor)
    {

        $title = trans('visitor.details');
        $action = 'show';
        return view('visitor.show', compact('visitor', 'title', 'action'));
    }

    /**
     *
     *
     * @param $website
     * @return Response
     */
    public function delete(User $visitor)
    {
        $title = trans('visitor.delete');
        return view('/visitor/delete', compact('visitor', 'title'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy(User $visitor)
    {
        Visitor::where('user_id', '=', $visitor->id)->delete();

        $visitor->delete();
        return redirect('/visitor');
    }

    public function data()
    {
        $visitors = $this->userRepository->getUsersForRole('visitor')
            ->map(function ($visitor) {
                return [
                    'id' => $visitor->id,
                    'full_name' => $visitor->full_name,
                ];
            });
        return Datatables::of($visitors)
            ->add_column('actions', ' @if(!Sentinel::inRole(\'admin\') || (Sentinel::inRole(\'admin\') && in_array(\'visitor.edit\', Sentinel::getUser()->permissions)))
                                        <a href="{{ url(\'/visitor/\' . $id . \'/show\' ) }}" class="btn btn-primary btn-sm" >
                                            <i class="fa fa-eye"></i>  {{ trans("table.details") }}</a>
                                     @endif
                                     <a href="{{ url(\'/visitor_card/\' . $id ) }}"  target="_blank" class="btn btn-success btn-sm" >
                                            <i class="fa fa-eye"></i>  {{ trans("visitor.visitor_card") }}</a>
                                      @if(!Sentinel::inRole(\'admin\') || (Sentinel::inRole(\'admin\') && in_array(\'visitor.delete\', Sentinel::getUser()->permissions)))
                                     <a href="{{ url(\'/visitor/\' . $id . \'/delete\' ) }}" class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash"></i> {{ trans("table.delete") }}</a>
                                     @endif')
            ->remove_column('id')
            ->make();
    }

}
