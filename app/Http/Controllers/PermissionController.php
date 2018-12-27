<?php

namespace App\Http\Controllers;

use Validator;

use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use App\Forms\PermissionForm;

use App\UserTypeSvcEquip;
use App\UserType;
use App\SvcEquip;

class PermissionController extends Controller
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
        return redirect()->route('requestitem.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return redirect()->route('permission.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return redirect()->route('permission.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($svcequip_id, FormBuilder $formBuilder)
    {
        $svcequip = SvcEquip::findOrFail($svcequip_id);
        return redirect()->route('permission.edit', $svcequip_id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($svcequip_id, FormBuilder $formBuilder)
    {
        $svcequip = SvcEquip::findOrFail($svcequip_id);
        $permission_records = UserTypeSvcEquip::where('svc_equip_id', $svcequip_id)->get();

        $exist_records = array();
        foreach ($permission_records as $permission_record)
        {
            if (!array_key_exists($permission_record->user_type_id, $exist_records))
            {
                $exist_records[$permission_record->user_type_id] = array();
            }

            $exist_records[$permission_record->user_type_id]['allow-show'] = true;
            $exist_records[$permission_record->user_type_id]['allow-notify'] = ($permission_record->accept_notify == 1);
            $exist_records[$permission_record->user_type_id]['allow-approve'] = ($permission_record->approve_right == 1);
        }

        //$dataset = Zone::findOrFail($id);
        $form = $formBuilder->create(PermissionForm::class, [
            //'model' => $dataset,
            'method' => 'patch',
            'route' => ['permission.update', $svcequip_id]
        ], ['exist_records' => $exist_records]);

        return view('zone.edit', compact('form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $svcequip_id)
    {
        $post_records = $request->post();
        foreach ($post_records as $key => $post_value)
        {
            if (is_int($key))
            {
                $allow_show = in_array('allow-show', $post_value);
                $allow_notify = in_array('allow-notify', $post_value);
                $allow_approve = in_array('allow-approve', $post_value);

                $permission_record = UserTypeSvcEquip::where('svc_equip_id', $svcequip_id)
                    ->where('user_type_id', $key)
                    ->take(1)->get();
                if (count($permission_record) > 0)
                {
                    $permission_record = $permission_record[0];
                    if ($allow_show == false)
                    {
                        $permission_record->delete();
                    }
                    else
                    {
                        $permission_record->accept_notify = $allow_notify ? 1 : 0;
                        $permission_record->approve_right = $allow_approve ? 1 : 0;
                        $permission_record->save();
                    }
                }
                else if ($allow_show)
                {
                    UserTypeSvcEquip::create([
                        'user_type_id' => $key,
                        'svc_equip_id' => $svcequip_id,
                        'accept_notify' => $allow_notify ? 1 : 0,
                        'approve_right' => $allow_approve ? 1 : 0,
                    ]);
                }
            }
        }

        UserTypeSvcEquip::where('svc_equip_id', $svcequip_id)->whereNotIn('user_type_id', array_keys($post_records))->delete();
        return redirect()->route('requestitem.index')
            ->with('success', 'Permission has been updated');

        // $request->validate([
        //     'name'=>'required',
        //     'desc'=> 'required',
        // ]);

        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Without destory function, return to index
        return redirect()->route('permission.index');
    }
}
