<?php

namespace App\Http\Controllers;

use Validator;
use Auth;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Telegram\Bot\Api;

use App\SvcEquipType;
use App\SvcEquipItems;
use App\AccessStatus;
use App\UserTypeSvcEquip;

use App\CommonFunctionSet;

class RequestController extends Controller
{
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

    private function svcequiptype_valid($svcequip_type)
    {
        if ($svcequip_type == null)
            return false;
        $this->type_record = SvcEquipType::where('keyname', $svcequip_type)->first();
        if ($this->type_record == null)
            return false;

        return true;
    }

    private function svcequipitem_valid($svcequip_type, $request_id)
    {
        if (!$this->svcequiptype_valid($svcequip_type))
            return false;
    
        $this->type_record->load('svc_equips.svc_equip_items');        
        $key_collection = collect([]);
        foreach ($this->type_record->svc_equips as $svc_equip)
        {
            if (count($svc_equip->svc_equip_items) == 0)
                return false;

            foreach ($svc_equip->svc_equip_items as $svc_equip_item)
            {
                if ($svc_equip_item->id == $request_id)
                {
                    $this->svc_equip_item = $svc_equip_item;
                    return true;
                }
            }  
        }

        return false;
    }

    private function get_usertype_id()
    {
        Auth::user()->load('user_type');
        return  Auth::user()->user_type->id;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $svcequip_type = null)
    {
        if (!$this->svcequiptype_valid($svcequip_type))
            return redirect()->route('home');


        $dataset = $this->type_record->load('svc_equips.svc_equip_items.svc_equip_category');
        $dataset = $this->type_record->load(['svc_equips' => function ($query) {
            $avail_svcequips_keys = collect(UserTypeSvcEquip::where('user_type_id', $this->get_usertype_id())->select('svc_equip_id')->get())->keys();
            $query->whereIn('id', $avail_svcequips_keys);
        }]);

        return view('request.index', [
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($svcequip_type, $request_id)
    {
        if (!$this->svcequipitem_valid($svcequip_type, $request_id))
            return redirect()->route('rq.index', $svcequip_type);
        
        return view('request.show', [
            'dataset' => [
                'request_item' => $this->svc_equip_item,
                'type_item' => $this->type_record,
                ]
            ]
        ); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $svcequip_type, $request_id)
    {
        if (!$this->svcequipitem_valid($svcequip_type, $request_id))
            return redirect()->route('rq.index', $svcequip_type);

        return view('request.edit', [
            'dataset' => [
                'request_item' => $this->svc_equip_item,
                'type_item' => $this->type_record,
                ]
            ]
        );   
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $svcequip_type, $request_id)
    {
        $request->validate([
            'name'=>'required',
            'desc'=> 'required',
        ]);

        if (!$this->svcequipitem_valid($svcequip_type, $request_id))
            return redirect()->route('rq.index', $svcequip_type);

        $update_record = $this->svc_equip_item;
        $update_record->name = $request->get('name');
        $update_record->desc = $request->get('desc');
        $update_record->save();

        return redirect()->route('rq.show', [$svcequip_type, $request_id])
            ->with('success', 'Record has been updated');
    }

    public function apply(Request $request, $svcequip_type, $request_id) 
    {
        if (!$this->svcequipitem_valid($svcequip_type, $request_id))
            return redirect()->route('rq.index', $svcequip_type);

        $new_request = new AccessStatus;
        $new_request->svcequipitem_id = $this->svc_equip_item->id;
        $new_request->user_id = Auth::user()->id;
        $new_request->status = 1;
        $new_request->request_enddate = Carbon::now()->addMonths(2);
        $new_request->save();

        CommonFunctionSet::SendApplyMsgToTG($new_request);

        return redirect()->route('rq.index', [$svcequip_type])
        ->with('success', 'Request has been submitted');
    }

    public function status(Request $request)
    {
        // if (CommonFunctionSet::RejectUserAccess(10))
        // {
        //     return redirect()->route('index')
        //         ->withErrors(['You have no permission. Contact System Administrator for any inquiry.']);
        // }

        Auth::user()->load('user_type');
        $user_typelevel = Auth::user()->user_type->typelevel;

        switch ($user_typelevel)
        {
            case 1:
            case 8:
                $dataset = AccessStatus::where('user_id', Auth::user()->id)
                ->orderby('created_at', 'desc')
                ->paginate($this->paginate);
                break;
            default:
                $dataset = AccessStatus::orderby('created_at', 'desc')
                ->paginate($this->paginate);
                break;
        }
        

        // $dataset = AccessStatus::where('user_id', Auth::user()->id)
        //     ->orderby('created_at', 'desc')
        //     ->paginate($this->paginate);
        $dataset->load('svc_equip_item', 'user', 'exec_trays');

        return view('request.status', [
            'dataset' => $dataset,
            ]
        );
    }

    public function approve_request(Request $request, $request_id)
    {
        $dataset = AccessStatus::findOrFail($request_id);
        $dataset->status = 2;
        $dataset->is_pending = 0;
        $dataset->save();

        $dataset->load('user', 'svc_equip_item');
        CommonFunctionSet::SendSuccessMsgToTG($dataset);
        
        return redirect()->route('rq.status')->with('success', 'Request has been approved.');
    }

    public function reject_request(Request $request, $request_id)
    {
        $dataset = AccessStatus::findOrFail($request_id);

        $dataset = AccessStatus::findOrFail($request_id);
        $dataset->status = 0;
        $dataset->is_pending = 0;
        $dataset->save();

        $dataset->load('user', 'svc_equip_item');
        CommonFunctionSet::SendRejectMsgToTG($dataset);
        
        return redirect()->route('rq.status')->with('success', 'Request has been rejected.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($svcequip_type, $request_id)
    {
        if (!$this->svcequipitem_valid($svcequip_type, $request_id))
            return redirect()->route('rq.index', $svcequip_type);

        $remove_record = $this->svc_equip_item;
        $remove_record->delete();

        return redirect()->route('rq.index', $svcequip_type, $request_id)
            ->with('success', 'Record has been updated');
    }
}
