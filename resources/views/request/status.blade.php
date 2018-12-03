@extends('layouts.panel')

@section('content')
<div class="container-fluid">
    <h4 class="c-grey-900 mT-10 mB-30">Request Status</h4>
    <p><a href="#">Request history</a> | In progress request <a href="#" class="badge badge-danger">9</a></p>
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
                <p>Action: <a href="#">Request multple items</a></p>
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
                        <tr>
                        <td><a href="{{ route('user.show', $data->user->id) }}">{{ $data->user->name }}</a></td>
                        <td>{{ $data->svc_equip_item->name }}</td>
                        <td>{{ $data->status }}</td>
                        <td>{{ $data->is_pending === 1 ? "Yes" : "No" }}</td>
                        <td>{{ $data->created_at }}</td>
                        <td><a href="#">Cancel</a> | <a href="#">Detail</a> | <a href="#">Approve</a> | <a href="#">Reject</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection