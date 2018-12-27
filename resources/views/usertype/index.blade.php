@extends('layouts.panel')

@section('content')
<div class="container-fluid">
    <h4 class="c-grey-900 mT-10 mB-30">User Type List</h4>
    <p>Show user by: ALL | <a href="#">Disabled</a> | <a href="#">Branch</a> | <a href="#">Department</a></p>
    <div class="row">
        <div class="col-md-12">
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                <!-- <h4 class="c-grey-900 mB-20">Simple Table</h4> -->
                <p>Action: <a href="{{ route('usertype.create') }}">Add</a> | <a href="#">Remove</a> | <a href="#">Modify</a> | <a href="#">Disable</a></p>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">User type</th>
                            <th scope="col">Type level</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dataset as $item)
                        <tr>
                            <th scope="row"><input type="checkbox" id="exampleCheck1"></th>
                            <td><a href="{{ route('usertype.show', $item->id) }}">{{ $item->name }}</a></td>
                            <td>{{ $item->typelevel }}</td>
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