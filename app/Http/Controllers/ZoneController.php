<?php

namespace App\Http\Controllers;

use Validator;

use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use App\Forms\ZoneForm;

use App\Zone;

class ZoneController extends Controller
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
        $dataset = Zone::paginate($this->paginate);

        return view('zone.index', [
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
        $form = $this->form(ZoneForm::class, [
            'method' => 'POST',
            'route' => 'zone.store'
        ]);

        return view('zone.create', [
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
            'name' => 'required|string|max:255|unique:zones',
            'desc' => 'required|string',
        ]);
        if ($validator->fails()) {
            return redirect()->route('zone.create')
                ->withErrors($validator)
                ->withInput();
        }

        Zone::create([
            'name' => $request->name,
            'desc' => $request->desc,
        ]);

        return redirect()->route('zone.index')->with('success', 'Zone has been created.');

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
    public function edit($id, FormBuilder $formBuilder)
    {
        $dataset = Zone::findOrFail($id);
        $form = $formBuilder->create(ZoneForm::class, [
            'model' => $dataset,
            'method' => 'patch',
            'route' => ['zone.update', $id]
        ]);

        return view('zone.edit', compact('form'));
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

        $dataset = Zone::findOrFail($id);
        $dataset->name = $request->name;
        $dataset->desc = $request->desc;
        $dataset->save();

        return redirect()->route('zone.index')
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
        //
    }
}
