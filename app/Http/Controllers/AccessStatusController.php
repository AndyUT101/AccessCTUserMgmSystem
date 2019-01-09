<?php

namespace App\Http\Controllers;

use Auth;
use Carbon\Carbon;

use Illuminate\Http\Request;

use App\AccessStatus;
use App\SvcEquipItems;
use App\User;
use App\BranchDept;

class AccessStatusController extends Controller
{
    protected $paginate = 15;
    protected $accstatus_dataset;

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
        if (!$this->grant_index_permission())
            return redirect()->route('useraccess.show', Auth::user()->id);

        $this->load_dataset();
        $dataset = $this->accstatus_dataset;

        return view('useraccess.index', [
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
    public function show($id)
    {
        $user_data = User::findOrFail($id);

        if (!collect($this->get_granted_userlist())->contains($id))
            return redirect()->route('useraccess.index');

        $this->load_dataset($user_data->id);
        $user_dataset = $this->accstatus_dataset;

        $accStatus_key = $user_dataset->access_status->pluck('id');
        $dataset = AccessStatus::whereIn('id', $accStatus_key)
            ->orderby('created_at', 'desc')
            ->paginate($this->paginate);
        
        return view('useraccess.show', [
            'user' => $user_data,
            'dataset' => $dataset,
            ]
        );
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


    private function load_dataset($user_id = 0)
    {
        $svcequip_dataset = SvcEquipItems::all()->load(['svc_equip.svc_equiptype' => function ($query) {
            $query->where('is_accessright', 1);
        }]);
        $accright_itemid = [];
        foreach ($svcequip_dataset as $svcequip)
        {
            if (collect($svcequip->svc_equip->svc_equiptype)->isNotEmpty())
                array_push($accright_itemid, $svcequip->id);
        }
        
        $is_indexpage = ($user_id == 0);
        if (!$is_indexpage)
        {
            $this->accstatus_dataset = User::findOrFail($user_id);
        }
        else
            $this->accstatus_dataset = User::whereIn('id', $this->get_granted_userlist())->paginate($this->paginate);

        $this->accstatus_dataset->load('branch_dept', 'user_type');
        $this->accstatus_dataset->load(['access_status.svc_equip_item', 'access_status' => function ($query) use($accright_itemid, $user_id) {
            $query->where('is_pending', 0);
            $query->where('status', 2);
            $query->whereIn('svcequipitem_id', $accright_itemid);
            $query->where('request_enddate', '>=', Carbon::today());
            if ($user_id != 0)
            {
                $query->where('user_id', $user_id);
            }
        }]);
    }

    private function grant_index_permission()
    {
        /*
         * 1: Normal User
         * 6: IT Staff (App.)
         * 7: IT Staff (Operation)
         */

        $read_only_ownrecord = collect([1, 6, 7]); 
        $user_record = Auth::user()->load('user_type');                
        return !$read_only_ownrecord->contains($user_record->user_type->typelevel);
    }


    private function get_granted_userlist()
    {
        $grant_userlist = collect();
        $curruser_records = Auth::user()->load('user_type', 'branch_dept');

        $grant_userlist->push(Auth::user()->id);
        switch ($curruser_records->user_type->typelevel)
        {
            case 1:
            case 6:
            case 7:
            break;

            case 2:
            case 5:
                if ($current_records->branch_dept->type != null)
                $grant_userlist = $grant_userlist->merge(collect(User::where('branchdept_id', $current_records->branch_dept->type)->get())->pluck('id')->toArray());
            break;

            case 3:
                if ($current_records->branch_dept->zone_id != null)
                {
                    $avilable_zonebranchKey = collect(BranchDept::where('zone_id', $current_records->branch_dept->zone_id)->get())->pluck('id');
                    $grant_userlist = $grant_userlist->merge(collect(User::whereIn('branchdept_id', $avilable_zonebranchKey)->get())->pluck('id')->toArray());
                }
            break;

            case 4:
            case 8:
                $grant_userlist = $grant_userlist->merge(collect(User::where('branchdept_id', '<>', null)->get())->pluck('id')->toArray());
            break;
        }

        return $grant_userlist->unique()->values()->all();
    }
}
