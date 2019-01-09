<?php

namespace App\Http\Controllers;

use Auth;
use Carbon\Carbon;

use Illuminate\Http\Request;

use App\CommonFunctionSet;
use App\AccessStatus;
use App\SvcEquipItems;
use App\User;


class HomeController extends Controller
{
    protected $accstatus_dataset;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware(['auth']);
        $this->middleware(['auth', '2fa']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pending_request = AccessStatus::where('user_id', Auth::user()->id)
            ->where('is_pending', 1)
            ->count();
        $pending_records = AccessStatus::where('user_id', Auth::user()->id)
            ->where('is_pending', 1)
            ->take(5)->get();
        foreach ($pending_records as $pending_record)
            $pending_record->load('svc_equip_item');



        $this->load_dataset(Auth::user()->id);
        $user_dataset = $this->accstatus_dataset;

        $accStatus_key = $user_dataset->access_status->pluck('id');
        $access_right_count = AccessStatus::whereIn('id', $accStatus_key)->count();

        return view('home', compact('pending_request', 'pending_records', 'access_right_count'));
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
}
