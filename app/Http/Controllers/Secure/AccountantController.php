<?php

namespace App\Http\Controllers\Secure;

use App\Helpers\CustomFormUserFields;
use App\Models\AccountantSchool;
use App\Models\School;
use App\Models\User;
use App\Repositories\UserRepository;
use Datatables;
use Efriandika\LaravelSettings\Facades\Settings;
use Session;
use DB;
use App\Helpers\Thumbnail;
use Sentinel;
use App\Http\Requests\Secure\TeacherRequest;

class AccountantController extends SecureController
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
        $this->middleware('authorized:accountant.show', ['only' => ['index', 'data']]);
        $this->middleware('authorized:accountant.create', ['only' => ['create', 'store']]);
        $this->middleware('authorized:accountant.edit', ['only' => ['update', 'edit']]);
        $this->middleware('authorized:accountant.delete', ['only' => ['delete', 'destroy']]);

        parent::__construct();

        $this->userRepository = $userRepository;

        view()->share('type', 'accountant');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $title = trans('accountant.accountant');
        return view('accountant.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $title = trans('accountant.new');
        $custom_fields =  CustomFormUserFields::getCustomUserFields(9);
        $all_schools = School::pluck('title', 'id')->toArray();
        return view('layouts.create', compact('title','custom_fields','all_schools'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TeacherRequest $request
     * @return Response
     */
    public function store(TeacherRequest $request)
    {
        $user = Sentinel::registerAndActivate($request->except('school_id'));

        $role = Sentinel::findRoleBySlug('accountant');
        $role->users()->attach($user);

        $user = User::find($user->id);

        if ($request->hasFile('image_file') != "") {
            $file = $request->file('image_file');
            $extension = $file->getClientOriginalExtension();
            $picture = str_random(10) . '.' . $extension;

            $destinationPath = public_path() . '/uploads/avatar/';
            $file->move($destinationPath, $picture);
            Thumbnail::generate_image_thumbnail($destinationPath . $picture, $destinationPath . 'thumb_' . $picture);
            $user->picture = $picture;
            $user->save();
        }

        $user->update($request->except('password','image_file'));


        CustomFormUserFields::storeCustomUserField(9, $user->id, $request);

        if(Settings::get('account_one_school')=='yes'){
            AccountantSchool::create(['school_id'=>$request->get('school_id'),'user_id'=>$user->id]);
        }

        return redirect('/accountant');
    }

    /**
     * Display the specified resource.
     *
     * @param User $accountant
     * @return Response
     */
    public function show(User $accountant)
    {
        $title = trans('accountant.details');
        $action = 'show';
        $custom_fields =  CustomFormUserFields::getCustomUserFieldValues(9,$accountant->id);
        return view('layouts.show', compact('accountant', 'title', 'action','custom_fields'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $accountant
     * @return Response
     */
    public function edit(User $accountant)
    {
        $title = trans('accountant.edit');
        $custom_fields =  CustomFormUserFields::fetchCustomValues(9,$accountant->id);
        $all_schools = School::pluck('title', 'id')->toArray();
        $accountant_schools = AccountantSchool::where('user_id', $accountant->id)->pluck('school_id', 'school_id')->toArray();
        return view('layouts.edit', compact('title', 'accountant','custom_fields','all_schools','accountant_schools'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TeacherRequest $request
     * @param User $accountant
     * @return Response
     */
    public function update(TeacherRequest $request, User $accountant)
    {
        if ($request->password != "") {
            $accountant->password = bcrypt($request->password);
        }
        if ($request->hasFile('image_file') != "") {
            $file = $request->file('image_file');
            $extension = $file->getClientOriginalExtension();
            $picture = str_random(10) . '.' . $extension;

            $destinationPath = public_path() . '/uploads/avatar/';
            $file->move($destinationPath, $picture);
            Thumbnail::generate_image_thumbnail($destinationPath . $picture, $destinationPath . 'thumb_' . $picture);
            $accountant->picture = $picture;
            $accountant->save();
        }

        $accountant->update($request->except('password','image_file'));
        CustomFormUserFields::updateCustomUserField(9, $accountant->id, $request);

        AccountantSchool::where('user_id',$accountant->id)->delete();

        if(Settings::get('account_one_school')=='yes'){
            AccountantSchool::create(['school_id'=>$request->get('school_id'),'user_id'=>$accountant->id]);
        }
        return redirect('/accountant');
    }

    /**
     * @param User $accountant
     * @return Response
     */
    public function delete(User $accountant)
    {
        $title = trans('accountant.delete');
        $custom_fields =  CustomFormUserFields::getCustomUserFieldValues(9,$accountant->id);
        return view('/accountant/delete', compact('accountant', 'title','custom_fields'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $accountant
     * @return Response
     */
    public function destroy(User $accountant)
    {
        $accountant->delete();
        return redirect('/accountant');
    }

    public function data()
    {
        $accountants = $this->userRepository->getUsersForRole('accountant')
            ->map(function ($accountant) {
                return [
                    'id' => $accountant->id,
                    'full_name' => $accountant->full_name,
                ];
            });
        return Datatables::of($accountants)
            ->add_column('actions', '@if(!Sentinel::inRole(\'admin\') || (Sentinel::inRole(\'admin\') && in_array(\'accountant.edit\', Sentinel::getUser()->permissions)))
                                        <a href="{{ url(\'/accountant/\' . $id . \'/edit\' ) }}" class="btn btn-success btn-sm" >
                                            <i class="fa fa-pencil-square-o "></i>  {{ trans("table.edit") }}</a>
                                    @endif
                                        <a href="{{ url(\'/accountant/\' . $id . \'/show\' ) }}" class="btn btn-primary btn-sm" >
                                            <i class="fa fa-eye"></i>  {{ trans("table.details") }}</a>
                                    @if(!Sentinel::inRole(\'admin\') || (Sentinel::inRole(\'admin\') && in_array(\'accountant.delete\', Sentinel::getUser()->permissions)))
                                        <a href="{{ url(\'/accountant/\' . $id . \'/delete\' ) }}" class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash"></i> {{ trans("table.delete") }}</a>
                                     @endif')
            ->remove_column('id')
            ->make();
    }

}
