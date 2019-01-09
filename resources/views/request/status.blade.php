@extends('layouts.panel')

@section('content')
<div class="container-fluid">
    <h4 class="c-grey-900 mT-10 mB-30">Request Status</h4>
    <p><a href="{{ route('rq.status') }}">Current requests</a> | <a href="{{ route('rq.status', ['mode' => 'me']) }}">Show only my request</a></p>
    @if(\Session::has('success'))
    <div class="alert alert-success">
        {{ Session::get('success') }}
    </div>
    @endif
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <div class="row">
        <div class="col-md-12">
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                <h4 class="c-grey-900 mB-20"></h4>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col" width="50">User</th>
                            <th scope="col">Request item</th>
                            <th scope="col">Status code</th>
                            <th scope="col">Pending</th>
                            <th scope="col">Request date</th>
                            <th scope="col">Operation</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dataset as $data)
                        @if (count($data->svc_equip_item->svc_equip->usertype_svcequip) > 0)
                        @php
                            $has_approve_right = $data->svc_equip_item->svc_equip->usertype_svcequip->first()->approve_right == 1;
                        @endphp
                        @endif
                        <tr>
                        <td><a href="{{ route('user.show', $data->user->id) }}">{{ $data->user->name }}</a></td>
                        <td>{{ $data->svc_equip_item->name }}</td>
                        <td>{{ $data->StatusText }}</td>
                        <td>{{ $data->is_pending === 1 ? "Yes" : "No" }}</td>
                        <td>{{ $data->created_at }}</td>
                        <td><!--<a href="#">Cancel</a> | --><a href="{{ route('rq.detail', $data->id) }}">Detail</a>@if ($data->is_pending === 1 && $has_approve_right) | <a href="{{ route('rq.approve', $data->id) }}">Approve</a> | <a href="{{ route('rq.reject', $data->id) }}">Reject</a>@endif</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $dataset->links() }}
            </div>
        </div>
    </div>
</div>
@endsection