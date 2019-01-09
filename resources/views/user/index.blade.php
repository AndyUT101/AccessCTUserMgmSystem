@extends('layouts.panel')

@section('content')
<div class="container-fluid">
    <h4 class="c-grey-900 mT-10 mB-30">User List</h4>
    <p>Show user by: <a href="{{ route('user.index') }}">ALL</a> | <a href="{{ route('user.index', ['mode' => 'disabled']) }}">Disabled</a> | <a href="{{ route('user.index', ['mode' => 'branch']) }}">Branch</a> | <a href="{{ route('user.index', ['mode' => 'dept']) }}">Department</a></p>
    <div class="row">
        <div class="col-md-12">
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                <!-- <h4 class="c-grey-900 mB-20">Simple Table</h4> -->
                <p>Action: <a href="{{ route('user.create') }}">Add</a></p>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">User</th>
                            <th scope="col">Email</th>
                            <th scope="col">Branch/Department</th>
                            <th scope="col">User type</th>
                            <th scope="col">Last login time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dataset as $item)
                        <tr>
                            <th scope="row"><input type="checkbox" id="exampleCheck1"></th>
                            <td><a href="{{ route('user.show', $item->id) }}">{{ $item->name }}</a></td>
                            <td>{{ $item->email }}</td>
                            <td><span class="badge badge-dark" style="text-transform: uppercase;">{{ $item->branch_dept->type }}</span> {{ $item->branch_dept->name }}</td>
                            <td>{{ $item->user_type->name }}</td>
                            <td><span title="{{ $item->last_login }}">{{ $item->last_login_by_ago }}</span></td>
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