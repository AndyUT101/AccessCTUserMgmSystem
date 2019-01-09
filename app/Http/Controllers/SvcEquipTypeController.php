<?php

namespace App\Http\Controllers;

use Validator;

use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use App\Forms\SvcEquipTypeForm;

use App\SvcEquipType;

class SvcEquipTypeController extends Controller
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
        $this->middleware(['auth', '2fa']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataset = SvcEquipType::paginate($this->paginate);
        $dataset->load('svc_equips.svc_equip_items');

        return view('subsystem.index', [
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
        $form = $this->form(SvcEquipTypeForm::class, [
            'method' => 'POST',
            'route' => 'subsystem.store'
        ]);

        return view('subsystem.create', [
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
            'keyname' => 'required|string|without_spaces|max:255|unique:svc_equip_types',
            'name' => 'required|string|max:255',
            'desc' => 'required|string',
            'is_accessright' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->route('subsystem.create')
                ->withErrors($validator)
                ->withInput();
        }

        SvcEquipType::create([
            'keyname' => $request->keyname,
            'name' => $request->name,
            'desc' => $request->desc,
            'is_accessright' => $request->is_accessright ? 1 : 0,

        ]);

        return redirect()->route('subsystem.index')->with('success', 'Subsystem has been created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $dataset = SvcEquipType::findOrFail($id);
        return view('subsystem.show', compact('dataset')); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, FormBuilder $formBuilder)
    {
        $dataset = SvcEquipType::findOrFail($id);
        $form = $formBuilder->create(SvcEquipTypeForm::class, [
            'model' => $dataset,
            'method' => 'patch',
            'route' => ['subsystem.update', $id]
        ]);

        return view('subsystem.edit', compact('form'));
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
        $request->validate([
            'name'=>'required',
            'desc'=> 'required',
        ]);

        $dataset = SvcEquipType::findOrFail($id);
        $dataset->name = $request->name;
        $dataset->desc = $request->desc;
        $dataset->is_accessright = $request->is_accessright ? 1 : 0;
        $dataset->save();

        return redirect()->route('subsystem.index')
            ->with('success', 'Record has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $remove_record = SvcEquipType::findOrFail($id);
        $remove_record->delete();

        return redirect()->route('subsystem.index')
            ->with('success', 'Record has been removed');
    }
}
