@extends('layouts.panel')

@section('content')
<div class="container-fluid">
    <h4 class="c-grey-900 mT-10 mB-30">Request item</h4>
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
                <p>Action: <a href="{{ route('requestitem.create') }}">Add request item</a></p>
                @foreach ($dataset->groupBy('svc_equip.name') as $records)
                @foreach ($records as $record)
                @if ($loop->first)
                <h4 class="c-grey-900 mB-20">{{ $record['svc_equip']['name'] }} <span style="float: right"><a class="btn btn-info" href="{{ route('permission.edit', $record['svc_equip']['id']) }}" role="button">Update Permission</a></span></h4>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col" width="50">Category</th>
                            <th scope="col">Item</th>
                            <th scope="col">Request</th>
                        </tr>
                    </thead>
                    <tbody>
                @endif
                        <tr>
                            <td><span class="badge badge-danger">{{ $record['svc_equip_category']['name'] }}</span></td>
                            <td>{{ $record['name'] }}</td>
                            <td><a class="btn btn-secondary" href="{{ route('requestitem.edit', $record['id']) }}" role="button">Edit</a> <form action="{{ route('requestitem.destroy', $record['id']) }}" method="post" style="display:inline-block">@csrf<input name="_method" type="hidden" value="DELETE">
                    <button type="submit" class="btn btn-secondary">Remove</button>
                    </form></td>
                        </tr>
                @if ($loop->last)
                    </tbody>
                </table>
                @endif
                @endforeach
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection