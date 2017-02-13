<?php

namespace App\Http\Controllers\Secure;

use App\Http\Requests;
use App\Models\Transportation;
use App\Models\TransportationLocation;
use App\Repositories\TransportationRepository;
use Datatables;
use Session;
use App\Http\Requests\Secure\TransportationRequest;

class TransportationController extends SecureController
{
    /**
     * @var TransportationRepository
     */
    private $transportationRepository;

    /**
     * TransportationController constructor.
     * @param TransportationRepository $transportationRepository
     */
    public function __construct(TransportationRepository $transportationRepository)
    {
        parent::__construct();

        $this->transportationRepository = $transportationRepository;

        $this->middleware('authorized:transportation.show', ['only' => ['index', 'data']]);
        $this->middleware('authorized:transportation.create', ['only' => ['create', 'store']]);
        $this->middleware('authorized:transportation.edit', ['only' => ['update', 'edit']]);
        $this->middleware('authorized:transportation.delete', ['only' => ['delete', 'destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $this->generateParams();
        $title = trans('transportation.transportation');
        $hide_add = 0;
        if ($this->user->inRole('teacher') || $this->user->inRole('student') || $this->user->inRole('parent')) {
            $hide_add = 1;
        }

        return view('transportation.index', compact('title', 'hide_add'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $this->generateParams();
        $title = trans('transportation.new');
        return view('layouts.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(TransportationRequest $request)
    {
        $transportation = new Transportation($request->only('title'));
        $transportation->school_id = session('current_school');
        $transportation->save();
        foreach ($request['location'] as $location) {
            $trans_location = new TransportationLocation();
            $trans_location->transportation_id = $transportation->id;
            $trans_location->name = $location;
            $trans_location->lat = '';
            $trans_location->lang = '';
            $trans_location->save();
        }
        return redirect('/transportation');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show(Transportation $transportation)
    {
        $this->generateParams();
        $title = trans('transportation.details');
        $action = 'show';
        return view('layouts.show', compact('transportation', 'title', 'action'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit(Transportation $transportation)
    {
        $this->generateParams();
        $title = trans('transportation.edit');
        return view('layouts.edit', compact('title', 'transportation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update(TransportationRequest $request, Transportation $transportation)
    {
        $transportation->update($request->only('title'));
        TransportationLocation::where('transportation_id', $transportation->id)->delete();

        foreach ($request['location'] as $location) {
            $trans_location = new TransportationLocation();
            $trans_location->transportation_id = $transportation->id;
            $trans_location->name = $location;
            $trans_location->lat = '';
            $trans_location->lang = '';
            $trans_location->save();
        }

        return redirect('/transportation');
    }

    /**
     *
     *
     * @param $website
     * @return Response
     */
    public function delete(Transportation $transportation)
    {
        $this->generateParams();
        $title = trans('transportation.delete');
        return view('/transportation/delete', compact('transportation', 'title'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy(Transportation $transportation)
    {
        $transportation->delete();
        return redirect('/transportation');
    }

    public function data()
    {
        $transportation = $this->transportationRepository->getAllForSchool(session('current_school'))
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'title' => $item->title,
                ];
            });
        $hide_edit = 0;
        if ($this->user->inRole('teacher') || $this->user->inRole('student') || $this->user->inRole('parent')) {
            $hide_edit = 1;
            if ($this->user->inRole('teacher')) {
                $type = 'transportteacher';
            } elseif ($this->user->inRole('student')) {
                $type = 'transportstudent';
            } elseif ($this->user->inRole('parent')) {
                $type = 'transportparent';
            }
        }
        return Datatables::of($transportation)
            ->add_column('actions', ($hide_edit == 0) ?
                                    '@if(!Sentinel::getUser()->inRole(\'admin\') || Sentinel::getUser()->inRole(\'super_admin\') || (Sentinel::getUser()->inRole(\'admin\') && Settings::get(\'multi_school\') == \'no\') || (Sentinel::getUser()->inRole(\'admin\') && in_array(\'transportation.edit\', Sentinel::getUser()->permissions)))
                                        <a href="{{ url(\'/transportation/\' . $id . \'/edit\' ) }}" class="btn btn-success btn-sm" >
                                            <i class="fa fa-pencil-square-o "></i>  {{ trans("table.edit") }}</a>
                                   @endif
                                    <a href="{{ url(\'/transportation/\' . $id . \'/show\' ) }}" class="btn btn-primary btn-sm" >
                                            <i class="fa fa-eye"></i>  {{ trans("table.details") }}</a>
                                     @if(!Sentinel::getUser()->inRole(\'admin\') || Sentinel::getUser()->inRole(\'super_admin\') || (Sentinel::getUser()->inRole(\'admin\') && Settings::get(\'multi_school\') == \'no\') || (Sentinel::getUser()->inRole(\'admin\') && in_array(\'transportation.delete\', Sentinel::getUser()->permissions)))
                                     <a href="{{ url(\'/transportation/\' . $id . \'/delete\' ) }}" class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash"></i> {{ trans("table.delete") }}</a>
                                     @endif' :
                '<a href="{{ url(\'/' . $type . '/\' . $id . \'/show\' ) }}" class="btn btn-primary btn-sm" >
                                            <i class="fa fa-eye"></i>  {{ trans("table.details") }}</a>')
            ->remove_column('id')
            ->make();
    }

    private function generateParams()
    {
        if ($this->user->inRole('teacher')) {
            view()->share('type', 'transportteacher');
        } elseif ($this->user->inRole('student')) {
            view()->share('type', 'transportstudent');
        } elseif ($this->user->inRole('parent')) {
            view()->share('type', 'transportparent');
        } else {
            view()->share('type', 'transportation');
        }
    }

}
