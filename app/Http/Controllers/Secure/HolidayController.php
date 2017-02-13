<?php

namespace App\Http\Controllers\Secure;

use App\Models\Holiday;
use App\Http\Requests\Secure\HolidayRequest;
use Datatables;
use Session;

class HolidayController extends SecureController
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('authorized:holiday.show', ['only' => ['index', 'data']]);
        $this->middleware('authorized:holiday.create', ['only' => ['create', 'store']]);
        $this->middleware('authorized:holiday.edit', ['only' => ['update', 'edit']]);
        $this->middleware('authorized:holiday.delete', ['only' => ['delete', 'destroy']]);

        view()->share('type', 'holiday');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $title = trans('holiday.holiday');
        return view('holiday.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $title = trans('holiday.new');
        return view('layouts.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(HolidayRequest $request)
    {
        $holiday = new Holiday($request->all());
        $holiday->school_id = session('current_school');
        $holiday->save();

        return redirect('/holiday');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show(Holiday $holiday)
    {
        $title = trans('holiday.details');
        $action = 'show';
        return view('layouts.show', compact('holiday', 'title', 'action'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit(Holiday $holiday)
    {
        $title = trans('holiday.edit');
        return view('layouts.edit', compact('title', 'holiday'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update(HolidayRequest $request, Holiday $holiday)
    {
        $holiday->update($request->all());
        return redirect('/holiday');
    }

    /**
     *
     *
     * @param $website
     * @return Response
     */
    public function delete(Holiday $holiday)
    {
        $title = trans('holiday.delete');
        return view('/holiday/delete', compact('holiday', 'title'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy(Holiday $holiday)
    {
        $holiday->delete();
        return redirect('/holiday');
    }

    public function data()
    {
        $holiday = Holiday::where('school_id', session('current_school'))
            ->select(array('holidays.id', 'holidays.title', 'holidays.date'));

        return Datatables::of($holiday)
            ->add_column('actions', '@if(!Sentinel::getUser()->inRole(\'admin\') || Sentinel::getUser()->inRole(\'super_admin\') || (Sentinel::getUser()->inRole(\'admin\') && Settings::get(\'multi_school\') == \'no\') || (Sentinel::getUser()->inRole(\'admin\') && in_array(\'holiday.edit\', Sentinel::getUser()->permissions)))
                                        <a href="{{ url(\'/holiday/\' . $id . \'/edit\' ) }}" class="btn btn-success btn-sm" >
                                            <i class="fa fa-pencil-square-o "></i>  {{ trans("table.edit") }}</a>
                                    @endif
                                    <a href="{{ url(\'/holiday/\' . $id . \'/show\' ) }}" class="btn btn-primary btn-sm" >
                                            <i class="fa fa-eye"></i>  {{ trans("table.details") }}</a>
                                    @if(!Sentinel::getUser()->inRole(\'admin\') || Sentinel::getUser()->inRole(\'super_admin\') || (Sentinel::getUser()->inRole(\'admin\') && Settings::get(\'multi_school\') == \'no\') || (Sentinel::getUser()->inRole(\'admin\') && in_array(\'holiday.delete\', Sentinel::getUser()->permissions)))
                                        <a href="{{ url(\'/holiday/\' . $id . \'/delete\' ) }}" class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash"></i> {{ trans("table.delete") }}</a>
                                    @endif')
            ->remove_column('id')
            ->make();
    }
}
