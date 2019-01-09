<?php

namespace App\Http\Controllers;

use Auth;
use Uuid;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Validator;

use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use App\Forms\UserForm;
use App\Forms\EnhancedAuthForm;

use App\CommonFunctionSet;
use App\User;
use App\UserType;
use App\BranchDept;

class UserController extends Controller
{
    use FormBuilderTrait;

    protected $paginate = 15;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
        $this->middleware(['auth', '2fa']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $record_mode = $request->get('mode', '');
        switch ($record_mode)
        {
            case 'disabled':
                $dataset = User::where('is_disable', 1)->paginate($this->paginate);
            break;
            case 'branch':
                $branch_keys = collect(BranchDept::where('type', 'branch')->get())->pluck('id');
                $dataset = User::whereIn('branchdept_id', $branch_keys)->paginate($this->paginate);
            break;
            case 'dept':
                $dept_keys = collect(BranchDept::where('type', 'dept')->get())->pluck('id');
                $dataset = User::whereIn('branchdept_id', $dept_keys)->paginate($this->paginate);
            break;            
            default:
                $dataset = User::paginate($this->paginate);
            break;
        }
        $dataset->load('branch_dept', 'user_type');
        return view('user.index', [
            'dataset' => $dataset->appends(Input::except('page')),
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $form = $this->form(UserForm::class, [
            'method' => 'POST',
            'route' => 'user.store'
        ], ['active_user' => Auth::user()]);

        return view('user.create', [
            'form' => $form,
            ]
        );

        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|size:6',
            'email' => 'required|string|email|max:255|unique:users',
            // 'password' => 'required|string|min:6|confirmed',
        ]);
        if ($validator->fails()) {
            return redirect()->route('user.create')
                ->withErrors($validator)
                ->withInput();
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->name),
            'uuid' => Uuid::generate(4)->string,
        ]);

        return redirect()->route('user.index')->with('success', 'User has been created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $dataset = User::findOrFail($id);
        return view('user.show', compact('dataset')); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, FormBuilder $formBuilder)
    {
        $dataset = User::findOrFail($id);
        $form = $formBuilder->create(UserForm::class, [
            'model' => $dataset,
            'method' => 'patch',
            'route' => ['user.update', $id]
        ], ['active_user' => Auth::user()]);

        return view('user.edit', compact('form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            // 'name' => 'required|string|size:6',
            'email' => 'required|string|email|max:255|unique:users,email,'.$id,
            // 'password' => 'required|string|min:6|confirmed',
        ]);
        if ($validator->fails()) {
            return redirect()->route('user.create')
                ->withErrors($validator)
                ->withInput();
        }

        $dataset = User::findOrFail($id);
        $dataset->email = $request->email;
        $dataset->first_name = $request->first_name;
        $dataset->last_name = $request->last_name;
        $dataset->usertype_id = $request->usertype_id;
        $dataset->is_disable = $request->is_disable ? 1 : 0;
        $dataset->save();

        return redirect()->route('user.index')->with('success', 'User has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $remove_record = User::findOrFail($id);
        $remove_record->delete();

        return redirect()->route('user.index')
            ->with('success', 'User has been removed');
    }

    public function setEnhancedAuth(Request $request)
    {
        $fa_key = $request->post('fa-key', '');
        $user_secret = $request->post('user-secret', '');
        $show_error = false;

        $google2fa = app('pragmarx.google2fa');
        $google2fa_secret = ($fa_key === '') ? $google2fa->generateSecretKey() : $fa_key;

        if ($fa_key !== '')
        {
            $valid = $google2fa->verifyKey($fa_key, $user_secret);
            if ($valid)
            {
                Auth::user()->set2FAToken($fa_key);
                Auth::user()->save();

                Auth::logout();
                return redirect('/');
            }

            $show_error = true;
        }

        $form = $this->form(EnhancedAuthForm::class, [
            'method' => 'POST',
            'route' => 'user.2fa'
        ],  ['fa_key' => $google2fa_secret]);

        $QR_Image = $google2fa->getQRCodeInline(
            config('app.name'),
            Auth::user()->email,
            $google2fa_secret
        );

        return view('google2fa.register', [
            'QR_Image' => $QR_Image, 
            'secret' => $google2fa_secret,
            'form' => $form,
            'show_error' => $show_error,
        ]);
    }
}
