<?php

namespace App\Http\Controllers;

use Validator;
use Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use Carbon\Carbon;
use Telegram\Bot\Api;

use App\SvcEquipType;
use App\SvcEquipItems;
use App\AccessStatus;
use App\UserTypeSvcEquip;
use App\BranchDept;
use App\User;

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
        $avail_svcequips_keys = collect(UserTypeSvcEquip::where('user_type_id', $this->get_usertype_id())->select('svc_equip_id')->get())->pluck('svc_equip_id');
        $dataset = $this->type_record->load(['svc_equips' => function ($query) use($avail_svcequips_keys) {
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
        $new_request->require_parameters = [];
        $new_request->save();

        $msg_parameters = array 
        (
            'user' => Auth::user()->name,
            'request_name' => $this->svc_equip_item->name,
            'request_date' => (new Carbon($new_request->created_at))->toDateTimeString(),
        );
        CommonFunctionSet::PushMessageToQueue(Auth::user()->id, 'apply-success', $msg_parameters);  
        
        return redirect()->route('rq.index', [$svcequip_type])
        ->with('success', 'Request has been submitted');
    }

    public function status(Request $request)
    {
        $record_mode = $request->get('mode', '');
        
        switch ($record_mode)
        {
            case 'me':
                $dataset = AccessStatus::where('user_id', Auth::user()->id)
                ->orderby('created_at', 'desc')
                ->paginate($this->paginate);
            break;
            default:
                $dataset = AccessStatus::whereIn('user_id', $this->get_granted_userlist())
                    ->orderby('created_at', 'desc')
                    ->paginate($this->paginate);
            break;
        }

        Auth::user()->load('user_type');
        $user_typelevel = Auth::user()->user_type->typelevel;
        $dataset->load('user', 'exec_trays');
        $dataset->load(['svc_equip_item.svc_equip.usertype_svcequip' => function ($query) use($user_typelevel) 
            {
                $query->where('user_type_id', $user_typelevel);
            }
        ]);
        return view('request.status', [
            'dataset' => $dataset->appends(Input::except('page')),
            ]
        );
    }

    public function request_detail($access_id)
    {
        $dataset = AccessStatus::findOrFail($access_id);

        Auth::user()->load('user_type');
        $user_typelevel = Auth::user()->user_type->typelevel;
        $dataset->load('user', 'exec_trays');
        $dataset->load(['svc_equip_item.svc_equip.usertype_svcequip' => function ($query) use($user_typelevel) 
            {
                $query->where('user_type_id', $user_typelevel);
            }
        ]);

        return view('request.detail', [
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

        $dataset->load('user', 'svc_equip_item.svc_equip');

        $pushmsg_useridlist = $this->get_pushmsg_userlist($dataset->user, $dataset->svc_equip_item->svc_equip);
        foreach ($pushmsg_useridlist as $user_id)
        {
            $msg_parameters = array 
            (
                'user' => User::find($user_id)->name,
                'request_user' => $dataset->user->name,
                'request_name' => $dataset->svc_equip_item->name,
                'request_date' => (new Carbon($dataset->svc_equip_item->created_at))->toDateTimeString(),
            );

            CommonFunctionSet::PushMessageToQueue($user_id, 'request-approved', $msg_parameters);    
        }

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

        $pushmsg_useridlist = $this->get_pushmsg_userlist($dataset->user, $dataset->svc_equip_item->svc_equip);
        foreach ($pushmsg_useridlist as $user_id)
        {
            $msg_parameters = array 
            (
                'user' => User::find($user_id)->name,
                'request_user' => $dataset->user->name,
                'request_name' => $dataset->svc_equip_item->name,
                'request_date' => (new Carbon($dataset->svc_equip_item->created_at))->toDateTimeString(),
            );

            CommonFunctionSet::PushMessageToQueue($user_id, 'request-rejected', $msg_parameters);    
        }
        //CommonFunctionSet::SendRejectMsgToTG($dataset);
        
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


    /* 
     * Permission
     */
    private function get_granted_userlist()
    {
        $grant_userlist = collect();
        $curruser_records = Auth::user()->load('user_type', 'branch_dept');

        $grant_userlist->push(Auth::user()->id);
        switch ($curruser_records->user_type->typelevel)
        {
            case 1:
            case 6:
            break;

            case 2:
            case 5:
                if ($curruser_records->branch_dept->type != null)
                $grant_userlist = $grant_userlist->merge(collect(User::where('branchdept_id', $curruser_records->branch_dept->type)->get())->pluck('id')->toArray());
            break;

            case 3:
                if ($curruser_records->branch_dept->zone_id != null)
                {
                    $avilable_zonebranchKey = collect(BranchDept::where('zone_id', $curruser_records->branch_dept->zone_id)->get())->pluck('id');
                    $grant_userlist = $grant_userlist->merge(collect(User::whereIn('branchdept_id', $avilable_zonebranchKey)->get())->pluck('id')->toArray());
                }
            break;

            case 4:
            case 7:
            case 8:
                $grant_userlist = $grant_userlist->merge(collect(User::where('branchdept_id', '<>', null)->get())->pluck('id')->toArray());
            break;
        }

        return $grant_userlist->unique()->values()->all();
    }

    private function get_pushmsg_userlist($user, $svc_equip)
    {
        $pushmsg_user = collect();
        $curruser_records = $user->load('user_type', 'branch_dept');
        $pushmsg_user->push($user->id);
        
        switch ($curruser_records->user_type->typelevel)
        {
            case 1:
            break;

            case 2:
                $pushmsg_user = $pushmsg_user->merge(collect(User::whereIn('usertype_id', [6, 7, 8])->get())->pluck('id')->toArray());
            break;

            case 3:
                $pushmsg_user = $pushmsg_user->merge(collect(User::whereIn('usertype_id', [6, 7, 8])->get())->pluck('id')->toArray());

                $avilable_zonebranchKey = collect(BranchDept::where('zone_id', $user->branch_dept->zone_id)->get())->pluck('id');
                $pushmsg_user = $pushmsg_user->merge(collect(User::whereIn('branchdept_id', $avilable_zonebranchKey)
                    ->where('usertype_id', 2)->get())->pluck('id')->toArray());
            break;

            case 4:
                $pushmsg_user = $pushmsg_user->merge(collect(User::whereIn('usertype_id', [2, 3, 4, 6, 7, 8])->get())->pluck('id')->toArray());
            break;

            case 5:
                $pushmsg_user = $pushmsg_user->merge(collect(User::whereIn('usertype_id', [2, 3, 5, 6, 7, 8])->get())->pluck('id')->toArray());
            break;
        }

        return $pushmsg_user->unique()->values()->all();
    }

    public function tg()
    {
        return CommonFunctionSet::GetTGMsg();

        return "test";
    }
}
