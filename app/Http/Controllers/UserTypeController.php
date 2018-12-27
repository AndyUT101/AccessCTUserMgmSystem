<?php

namespace App\Http\Controllers;

use Validator;

use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use App\Forms\UserTypeForm;

use App\UserType;

class UserTypeController extends Controller
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
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataset = UserType::orderBy('typelevel', 'desc')->orderBy('name')->paginate($this->paginate);
        $dataset->load('users');

        return view('usertype.index', [
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
        $form = $this->form(UserTypeForm::class, [
            'method' => 'POST',
            'route' => 'usertype.store'
        ]);

        return view('usertype.create', [
            'form' => $form,
            ]
        );
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
            'name' => 'required|string|unique:user_types',
            'typelevel' => 'required|integer|max:100',
        ]);
        if ($validator->fails()) {
            return redirect()->route('usertype.create')
                ->withErrors($validator)
                ->withInput();
        }

        UserType::create([
            'name' => $request->name,
            'typelevel' => $request->typelevel,
        ]);

        return redirect()->route('usertype.index')->with('success', 'User type has been created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $remove_record = UserType::findOrFail($id);
        $remove_record->delete();

        return redirect()->route('usertype.index')
            ->with('success', 'User type has been removed');
    }
}
