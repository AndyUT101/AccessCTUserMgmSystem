<?php

namespace App\Http\Controllers;

use Validator;

use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use App\Forms\SvcEquipItemsForm;

use App\SvcEquipItems;

class SvcEquipItemsController extends Controller
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
        $dataset = SvcEquipItems::paginate($this->paginate);
        $dataset->load('svc_equip', 'svc_equip_category');

        
        // return $dataset->groupBy('svc_equip.name');
        return view('requestitem.index', [
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
        $form = $this->form(SvcEquipItemsForm::class, [
            'method' => 'POST',
            'route' => 'requestitem.store'
        ], ['is_admin' => true]);

        return view('requestitem.create', [
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
            'svc_equip_id' => 'required|exists:svc_equip_items,id',
            'item_category_id' => 'required|exists:svc_equip_categories,id',
            'name' => 'required|string|max:255|unique:zones',
            'desc' => 'required|string',
            'exec_command' => 'string',
        ]);
        if ($validator->fails()) {
            return redirect()->route('requestitem.create')
                ->withErrors($validator)
                ->withInput();
        }

        SvcEquipItems::create([
            'svc_equip_id' => $request->svc_equip_id,
            'item_category_id' => $request->item_category_id,
            'name' => $request->name,
            'desc' => $request->desc,
            'exec_command' => $request->exec_command,
            'require_parameters' => [],
        ]);

        return redirect()->route('requestitem.index')->with('success', 'Request item has been created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, FormBuilder $formBuilder)
    {
        $dataset = SvcEquipItems::findOrFail($id);
        $form = $formBuilder->create(SvcEquipItemsForm::class, [
            'model' => $dataset,
            'method' => 'patch',
            'route' => ['requestitem.update', $id]
        ]);

        return view('requestitem.edit', compact('form'));
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
            'svc_equip_id' => 'required|exists:svc_equip_items,id',
            'item_category_id' => 'required|exists:svc_equip_categories,id',
            'name' => 'required|string|max:255|unique:zones',
            'desc' => 'required|string',
            'exec_command' => 'string',
        ]);

        $dataset = SvcEquipItems::findOrFail($id);
        $dataset->svc_equip_id = $request->svc_equip_id;
        $dataset->item_category_id = $request->item_category_id;
        $dataset->name = $request->name;
        $dataset->desc = $request->desc;
        $dataset->exec_command = $request->exec_command;
        $dataset->require_parameters = ['test'=>'test',];
        $dataset->save();

        return redirect()->route('requestitem.index')
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
        $remove_record = SvcEquipItems::findOrFail($id);
        $remove_record->delete();

        return redirect()->route('requestitem.index')
            ->with('success', 'Record has been removed');
        
    }
}
