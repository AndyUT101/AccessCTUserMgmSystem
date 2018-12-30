<?php

namespace App\Http\Controllers;

use Validator;
use Auth;

use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use App\Forms\SvcEquipForm;

use App\SvcEquip;


class SvcEquipController extends Controller
{
    use FormBuilderTrait;

    protected $paginate = 15;

    protected $type_record;
    protected $svc_equip_item;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth']);
        // $this->middleware(['auth', '2fa']);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataset = SvcEquip::paginate($this->paginate);

        return view('svcequip.index', [
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
        $form = $this->form(SvcEquipForm::class, [
            'method' => 'POST',
            'route' => 'svcequip.store'
        ]);

        return view('svcequip.create', [
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
            'svc_equiptype_id' => 'required|exists:svc_equip_types,id',
            'keyname' => 'required|string|max:255|unique:svc_equips',
            'name' => 'required|string|max:255',
            'desc' => 'required|string',
        ]);
        if ($validator->fails()) {
            return redirect()->route('svcequip.create')
                ->withErrors($validator)
                ->withInput();
        }

        SvcEquip::create([
            'svc_equiptype_id' => $request->svc_equiptype_id,
            'keyname' => $request->keyname,
            'name' => $request->name,
            'desc' => $request->desc,
        ]);

        return redirect()->route('svcequip.index')->with('success', 'service/equipment item has been created.');
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
        //
    }
}
