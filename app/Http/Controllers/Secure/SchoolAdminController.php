<?php

namespace App\Http\Controllers\Secure;

use App\Helpers\CustomFormUserFields;
use App\Models\Permission;
use App\Models\SchoolAdmin;
use App\Models\User;
use App\Repositories\SchoolRepository;
use App\Repositories\UserRepository;
use Datatables;
use Sentinel;
use App\Http\Requests\Secure\SchoolAdminRequest;

class SchoolAdminController extends SecureController
{
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var SchoolRepository
     */
    private $schoolRepository;

    /**
     * SchoolAdminController constructor.
     * @param UserRepository $userRepository
     * @param SchoolRepository $schoolRepository
     */
    public function __construct(UserRepository $userRepository,
                                SchoolRepository $schoolRepository)
    {
        parent::__construct();

        $this->userRepository = $userRepository;
        $this->schoolRepository = $schoolRepository;

        view()->share('type', 'school_admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $title = trans('school_admin.school_admin');
        return view('school_admin.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $title = trans('school_admin.new');
        $school_ids = array('' => trans('school_admin.select_school')) + $this->schoolRepository->getAll()->pluck('title', 'id')->toArray();
        $custom_fields =  CustomFormUserFields::getCustomUserFields(2);
        $permission_groups = Permission::where('role_id','2')->groupBy('group_name')->select('id','group_name', 'group_slug')->get()->toArray();
        $permissions = Permission::where('role_id','2')->orderBy('group_name')->orderBy('id')->select('name','group_name')->get()->toArray();

        return view('layouts.create', compact('title', 'school_ids','custom_fields','permission_groups','permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param SchoolAdminRequest $request
     * @return Response
     */
    public function store(SchoolAdminRequest $request)
    {
        $user = Sentinel::registerAndActivate($request->all());

        $role = Sentinel::findRoleBySlug('admin');
        $role->users()->attach($user);

        $user = User::find($user->id);
        if ($request->hasFile('image_file') != "") {
            $file = $request->file('image_file');
            $extension = $file->getClientOriginalExtension();
            $document = str_random(10) . '.' . $extension;

            $destinationPath = public_path() . '/uploads/avatars/';
            $file->move($destinationPath, $document);
            $user->picture = $document;
        }

        $user->update($request->except('password','image_file'));

        $school_admin = new SchoolAdmin();
        $school_admin->school_id = $request->school_id;
        $school_admin->user_id = $user->id;
        $school_admin->save();

       CustomFormUserFields::storeCustomUserField(2, $school_admin->id, $request);

        foreach ($user->getPermissions() as $key => $item) {
            $user->removePermission($key);
        }

        foreach ($request->get('permissions', []) as $permission) {
            $user->addPermission($permission);
        }

        return redirect('/school_admin');
    }

    /**
     * Display the specified resource.
     *
     * @param User $school_admin
     * @return Response
     */
    public function show(User $school_admin)
    {
        $title = trans('school_admin.details');
        $action = 'show';
        $school = SchoolAdmin::where('user_id', $school_admin->id)->first();
        $custom_fields =  CustomFormUserFields::getCustomUserFieldValues(2,$school_admin->id);
        $permission_groups = Permission::where('role_id','2')->groupBy('group_name')->select('id','group_name', 'group_slug')->get()->toArray();
        $permissions = Permission::where('role_id','2')->orderBy('group_name')->orderBy('id')->select('name','group_name')->get()->toArray();

        return view('layouts.show', compact('school_admin', 'title', 'action', 'school','custom_fields','permission_groups','permissions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $school_admin
     * @return Response
     */
    public function edit(User $school_admin)
    {
        $title = trans('school_admin.edit');
        $school_ids = array('' => trans('school_admin.select_school')) + $this->schoolRepository->getAll()->pluck('title', 'id')->toArray();
        $schoolAdmin = SchoolAdmin::where('user_id', $school_admin->id)->first();
        $school_id = isset($schoolAdmin) ? $schoolAdmin->school_id : 0;
        $custom_fields =  CustomFormUserFields::fetchCustomValues(2,$school_admin->id);
        $permission_groups = Permission::where('role_id','2')->groupBy('group_name')->select('id','group_name', 'group_slug')->get()->toArray();
        $permissions = Permission::where('role_id','2')->orderBy('group_name')->orderBy('id')->select('name','group_name')->get()->toArray();

        return view('layouts.edit', compact('title', 'school_admin', 'school_ids', 'school_id','custom_fields','permission_groups','permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param SchoolAdminRequest $request
     * @param  User $school_admin
     * @return Response
     */
    public function update(SchoolAdminRequest $request, User $school_admin)
    {
        if ($request->password != "") {
            $school_admin->password = bcrypt($request->password);
        }
        if ($request->hasFile('image_file') != "") {
            $file = $request->file('image_file');
            $extension = $file->getClientOriginalExtension();
            $document = str_random(10) . '.' . $extension;

            $destinationPath = public_path() . '/uploads/avatars/';
            $file->move($destinationPath, $document);
            $school_admin->picture = $document;
        }
        $school_admin->update($request->except('password','image_file'));

        SchoolAdmin::where('user_id', '=', $school_admin->id)->delete();

        $schoolAdmin = new SchoolAdmin();
        $schoolAdmin->school_id = $request->school_id;
        $schoolAdmin->user_id = $school_admin->id;
        $schoolAdmin->save();

        CustomFormUserFields::updateCustomUserField(2, $school_admin->id, $request);

        foreach ($school_admin->getPermissions() as $key => $item) {
            $school_admin->removePermission($key);
        }

        foreach ($request->get('permissions', []) as $permission) {
            $school_admin->addPermission($permission);
        }

        return redirect('/school_admin');
    }

    /**
     *@param $school_admin
     * @return Response
     */
    public function delete(User $school_admin)
    {
        $title = trans('school_admin.delete');
        $school = SchoolAdmin::where('user_id', $school_admin->id)->first();
        $custom_fields =  CustomFormUserFields::getCustomUserFieldValues(2,$school_admin->id);
        $permission_groups = Permission::where('role_id','2')->groupBy('group_name')->select('id','group_name', 'group_slug')->get()->toArray();
        $permissions = Permission::where('role_id','2')->orderBy('group_name')->orderBy('id')->select('name','group_name')->get()->toArray();

        return view('/school_admin/delete', compact('school_admin', 'title', 'school','custom_fields','permission_groups','permissions'));
    }

    /**
     * Remove the specified resource from storage.
     * @param User $school_admin
     * @return Response
     */
    public function destroy(User $school_admin)
    {
        SchoolAdmin::where('user_id', '=', $school_admin->id)->delete();
        $school_admin->delete();
        return redirect('/school_admin');
    }

    public function data()
    {
        $schoolAdmins = $this->userRepository->getUsersForRole('admin')
            ->map(function ($schoolAdmin) {
                return [
                    'id' => $schoolAdmin->id,
                    'full_name' => $schoolAdmin->full_name,
                    'school' => (isset($schoolAdmin->school_admin) && isset($schoolAdmin->school_admin->school))?
                                        $schoolAdmin->school_admin->school->title:"",
                ];
            });
        return Datatables::of($schoolAdmins)
            ->add_column('actions', '<a href="{{ url(\'/school_admin/\' . $id . \'/edit\' ) }}" class="btn btn-success btn-sm" >
                                            <i class="fa fa-pencil-square-o "></i>  {{ trans("table.edit") }}</a>
                                    @if(Sentinel::getUser()->inRole(\'super_admin\'))
                                     <a href="{{ url(\'/login_as_user/\' . $id . \'\' ) }}" class="btn btn-warning btn-sm" >
                                            <i class="fa fa-exclamation-triangle"></i>  {{ trans("teacher.login_as_user") }}</a>
                                     @endif
                                     <a href="{{ url(\'/school_admin/\' . $id . \'/show\' ) }}" class="btn btn-primary btn-sm" >
                                            <i class="fa fa-eye"></i>  {{ trans("table.details") }}</a>
                                     <a href="{{ url(\'/school_admin/\' . $id . \'/delete\' ) }}" class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash"></i> {{ trans("table.delete") }}</a>')
            ->remove_column('id')
            ->make();
    }

}
