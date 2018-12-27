<?php

namespace App\Http\Controllers;

use Auth;
use Uuid;
use Illuminate\Support\Facades\Hash;
use Validator;

use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use App\Forms\UserForm;

use App\CommonFunctionSet;
use App\User;
use App\UserType;

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
    public function index()
    {
        $dataset = User::paginate($this->paginate);
        $dataset->load('branch_dept', 'user_type');

        return view('user.index', [
            'dataset' => $dataset,
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
}
