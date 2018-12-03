@extends('layouts.panel')

@section('content')
<div class="container-fluid">
    <h4 class="c-grey-900 mT-10 mB-30">Request {{ $dataset->name }}</h4>
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
                @foreach ($dataset->svc_equips as $svc_equip)
                @if (count($svc_equip->svc_equip_items) > 0)
                <h4 class="c-grey-900 mB-20">{{ $svc_equip->name }}</h4>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col" width="50">Category</th>
                            <th scope="col">Item</th>
                            <th scope="col">Request</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($svc_equip->svc_equip_items as $svc_equip_item)
                        <tr>
                            <td><span class="badge badge-danger">Reporting</span></td>
                            <td>{{ $svc_equip_item->name }} <a href="{{ route('rq.show', [$dataset->keyname, $svc_equip_item->id]) }}">[Detail]</a></td>
                            <td><a class="btn btn-primary" href="{{ route('rq.apply', [$dataset->keyname, $svc_equip_item->id]) }}" role="button">Request</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
                @endforeach

            </div>
        </div>
    </div>
</div>
@endsection