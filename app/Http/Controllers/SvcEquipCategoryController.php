<?php

namespace App\Http\Controllers;

use Validator;

use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use App\Forms\SvcEquipCategoryForm;

use App\SvcEquipCategory;

class SvcEquipCategoryController extends Controller
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
        $dataset = SvcEquipCategory::paginate($this->paginate);

        return view('subcategory.index', [
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
        $form = $this->form(SvcEquipCategoryForm::class, [
            'method' => 'POST',
            'route' => 'subcategory.store'
        ]);

        return view('subcategory.create', [
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
            'keyname' => 'required|string|max:255|unique:svc_equip_categories',
            'name' => 'required|string|max:255',
            'desc' => 'required|string',
        ]);
        if ($validator->fails()) {
            return redirect()->route('subcategory.create')
                ->withErrors($validator)
                ->withInput();
        }

        SvcEquipCategory::create([
            'keyname' => $request->keyname,
            'name' => $request->name,
            'desc' => $request->desc,
        ]);

        return redirect()->route('subcategory.index')->with('success', 'Sub-category has been created.');
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
        $remove_record = SvcEquipCategory::findOrFail($id);
        $remove_record->delete();

        return redirect()->route('subcategory.index')
            ->with('success', 'Record has been removed');
    }
}
