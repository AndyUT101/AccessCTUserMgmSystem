<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\UserType;

class UserController extends Controller
{
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

        // $search_keyword = $request->keyword;
        // if (is_null($request->keyword)) {
        //     $resource_objects = User::paginate(15);
        // } else {
        //     $resource_objects = User::SearchByKeyword($request->keyword)->paginate(15);
        // }
        // foreach ($resource_objects as $item) {
        //     $item->load('user_type');
        //     $item->load('pushmsg_users');
        //     $item->load('tickets');
        // }

        $dataset = User::paginate($this->paginate);
        $dataset->load('branch_dept', 'user_type');

        return view('user.index', [
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
