<?php

namespace App\Http\Controllers\Secure;

use App\Http\Requests\Secure\FeeCategoryRequest;
use App\Models\FeeCategory;
use App\Repositories\FeeCategoryRepository;
use Datatables;

class FeeCategoryController extends SecureController
{
    /**
     * @var FeeCategoryRepository
     */
    private $feeCategoryRepository;

    /**
     * FeeCategoryController constructor.
     * @param FeeCategoryRepository $feeCategoryRepository
     */
    public function __construct(FeeCategoryRepository $feeCategoryRepository)
    {
        parent::__construct();

        $this->feeCategoryRepository = $feeCategoryRepository;

        $this->middleware('authorized:fee_category.show', ['only' => ['index', 'data']]);
        $this->middleware('authorized:fee_category.create', ['only' => ['create', 'store']]);
        $this->middleware('authorized:fee_category.edit', ['only' => ['update', 'edit']]);
        $this->middleware('authorized:fee_category.delete', ['only' => ['delete', 'destroy']]);

        view()->share('type', 'fee_category');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $title = trans('fee_category.fee_categories');
        return view('fee_category.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $title = trans('fee_category.new');
        return view('layouts.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(FeeCategoryRequest $request)
    {
        $feeCategory = new FeeCategory($request->all());
        $feeCategory->save();

        return redirect('/fee_category');
    }

    /**
     * Display the specified resource.
     *
     * @param  FeeCategory $feeCategory
     * @return Response
     */
    public function show(FeeCategory $feeCategory)
    {
        $title = trans('fee_category.details');
        $action = 'show';
        return view('layouts.show', compact('feeCategory', 'title', 'action'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param FeeCategory $feeCategory
     * @return Response
     */
    public function edit(FeeCategory $feeCategory)
    {
        $title = trans('fee_category.edit');
        return view('layouts.edit', compact('title', 'feeCategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param  int $id
     * @return Response
     */
    public function update(FeeCategoryRequest $request, FeeCategory $feeCategory)
    {
        $feeCategory->update($request->all());
        return redirect('/fee_category');
    }


    public function delete(FeeCategory $feeCategory)
    {
        $title = trans('fee_category.delete');
        return view('/fee_category/delete', compact('feeCategory', 'title'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy(FeeCategory $feeCategory)
    {
        $feeCategory->delete();
        return redirect('/fee_category');
    }

    public function data()
    {
        $feeCategorys = $this->feeCategoryRepository->getAll()
            ->get()
            ->map(function ($feeCategory) {
                return [
                    'id' => $feeCategory->id,
                    'title' => $feeCategory->title,
                ];
            });

        return Datatables::of($feeCategorys)
            ->add_column('actions', '@if(!Sentinel::getUser()->inRole(\'admin\') || Sentinel::getUser()->inRole(\'super_admin\') || (Sentinel::getUser()->inRole(\'admin\') && Settings::get(\'multi_school\') == \'no\') || (Sentinel::getUser()->inRole(\'admin\') && in_array(\'fee_category.edit\', Sentinel::getUser()->permissions)))
                                    <a href="{{ url(\'/fee_category/\' . $id . \'/edit\' ) }}" class="btn btn-success btn-sm" >
                                            <i class="fa fa-pencil-square-o "></i>  {{ trans("table.edit") }}</a>
                                    @endif
                                    <a href="{{ url(\'/fee_category/\' . $id . \'/show\' ) }}" class="btn btn-primary btn-sm" >
                                            <i class="fa fa-eye"></i>  {{ trans("table.details") }}</a>
                                    @if(!Sentinel::getUser()->inRole(\'admin\') || Sentinel::getUser()->inRole(\'super_admin\') || (Sentinel::getUser()->inRole(\'admin\') && Settings::get(\'multi_school\') == \'no\') || (Sentinel::getUser()->inRole(\'admin\') && in_array(\'fee_category.delete\', Sentinel::getUser()->permissions)))
                                     <a href="{{ url(\'/fee_category/\' . $id . \'/delete\' ) }}" class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash"></i> {{ trans("table.delete") }}</a>
                                    @endif')
            ->remove_column('id')
            ->make();
    }
}
