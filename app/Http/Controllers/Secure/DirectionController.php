<?php

namespace App\Http\Controllers\Secure;

use App\Http\Requests\Secure\DirectionRequest;
use App\Models\Curricula;
use App\Models\Direction;
use App\Repositories\DirectionRepository;
use Guzzle\Http\Message\Response;
use Datatables;
use Session;

class DirectionController extends SecureController
{
    /**
     * @var DirectionRepository
     */
    private $directionRepository;

    /**
     * DirectionController constructor.
     * @param DirectionRepository $directionRepository
     */
    public function __construct(DirectionRepository $directionRepository)
    {
        parent::__construct();

        $this->directionRepository = $directionRepository;

        view()->share('type', 'direction');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $title = trans('direction.directions');
        return view('direction.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $title = trans('direction.new');
        return view('layouts.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request|DirectionRequest $request
     * @return Response
     */
    public function store(DirectionRequest $request)
    {
        $direction = new Direction($request->all());
        $direction->save();
        return redirect('/direction');
    }

    /**
     * Display the specified resource.
     *
     * @param Direction $direction
     * @return Response
     * @internal param int $id
     */
    public function show(Direction $direction)
    {
        $title = trans('direction.details');
        $action = 'show';
        return view('layouts.show', compact('direction', 'title', 'action'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Direction $direction
     * @return Response
     * @internal param int $id
     */
    public function edit(Direction $direction)
    {
        $title = trans('direction.edit');
        return view('layouts.edit', compact('title', 'direction'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request|DirectionRequest $request
     * @param Direction $direction
     * @return Response
     * @internal param int $id
     */
    public function update(DirectionRequest $request, Direction $direction)
    {
        $direction->update($request->all());
        return redirect('/direction');
    }

    public function delete(Direction $direction)
    {
        $title = trans('direction.delete');
        return view('/direction/delete', compact('direction', 'title'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy(Direction $direction)
    {
        $direction->delete();
        return redirect('/direction');
    }

    public function data()
    {
        $directions = $this->directionRepository->getAll()
            ->get()
            ->map(function ($direction) {
                return [
                    'id' => $direction->id,
                    'title' => $direction->title,
                    'duration' => $direction->duration,
                ];
            });

        return Datatables::of($directions)
            ->add_column('actions', '<a href="{{ url(\'/direction/\' . $id . \'/edit\' ) }}" class="btn btn-success btn-sm" >
                                            <i class="fa fa-pencil-square-o "></i>  {{ trans("table.edit") }}</a>
                                    <a href="{{ url(\'/direction/\' . $id . \'/show\' ) }}" class="btn btn-primary btn-sm" >
                                            <i class="fa fa-eye"></i>  {{ trans("table.details") }}</a>
                                     <a href="{{ url(\'/direction/\' . $id . \'/delete\' ) }}" class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash"></i> {{ trans("table.delete") }}</a>')
            ->remove_column('id')
            ->make();
    }
}
