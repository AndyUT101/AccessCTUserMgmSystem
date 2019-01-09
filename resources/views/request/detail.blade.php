@extends('layouts.panel')

@section('content')
<div class="container-fluid">
    <p><a href="{{ url()->previous() }}"><i class="ti-angle-left"></i> Return to previous page</a></p>
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
                <h4 class="c-grey-900 mB-20">{{ $dataset->svc_equip_item->name }}</h4>
                <div>
                <p><strong>Request name</strong> : {{ $dataset->svc_equip_item->name }}</p>
                <p><strong>Request user</strong> : <a href="{{ route('user.show', $dataset->user->id) }}">{{ $dataset->user->name }}</a></p>
                <p><strong>Request date</strong> : {{ $dataset->created_at }}</p>

                <p><strong>Request description</strong> : </p>
                <p>{!! nl2br($dataset->svc_equip_item->desc) !!}</p>
                @php
                    $has_approve_right = $dataset->svc_equip_item->svc_equip->usertype_svcequip->first()->approve_right == 1;
                @endphp
                @if ($dataset->is_pending === 1 && $has_approve_right)
                <p><strong>Process pending request:</strong></p>
                <a href="{{ route('rq.approve', $dataset->id) }}" class="btn btn-success" role="button">Approve</a> <a href="{{ route('rq.reject', $dataset->id) }}" class="btn btn-danger" role="button">Reject</a>
                @else 
                <p><strong>Request status:</strong></p>
                @if ($dataset->status === 2)
                <a href="#" class="btn btn-success disabled" role="button" aria-disabled="true">Approved</a>
                @elseif ($dataset->status === 3)
                <a href="#" class="btn btn-danger disabled" role="button" aria-disabled="true">Rejected</a>
                @else
                <a href="#" class="btn btn-info disabled" role="button" aria-disabled="true">Pending</a>
                @endif
                @endif
            </div>
        </div>
    </div>
</div>
@endsection