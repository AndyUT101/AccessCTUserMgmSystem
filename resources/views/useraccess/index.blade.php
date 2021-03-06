@extends('layouts.panel')

@section('content')
<div class="container-fluid">
    <h4 class="c-grey-900 mT-10 mB-30">Review user access right</h4>
    <p>Show by: ALL | <a href="{{ route('useraccess.show', Auth::user()->id) }}">My user access right</a></p>
    <div class="row">
        <div class="col-md-12">
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                <!-- <h4 class="c-grey-900 mB-20">Simple Table</h4> -->
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">User</th>
                            <th scope="col">Email</th>
                            <th scope="col">Branch/Department</th>
                            <th scope="col">User type</th>
                            <th scope="col">Last login time</th>
                            <th scope="col">Approved <br>access right</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dataset as $item)
                        <tr>
                            <th scope="row"></th>
                            <td><a href="{{ route('useraccess.show', $item->id) }}">{{ $item->name }}</a></td>
                            <td>{{ $item->email }}</td>
                            <td><span class="badge badge-dark" style="text-transform: uppercase;">{{ $item->branch_dept->type }}</span> {{ $item->branch_dept->name }}</td>
                            <td>{{ $item->user_type->name }}</td>
                            <td><span title="{{ $item->last_login }}">{{ $item->last_login_by_ago }}</span></td>
                            <td>{{ count($item->access_status) }}</td>
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