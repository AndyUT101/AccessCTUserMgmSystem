@extends('layouts.panel')

@section('content')
<div class="container">
<div class="row gap-20 masonry pos-r" style="position: relative; height: 1855px;">
    <div class="masonry-sizer col-md-6"></div>
    <div class="masonry-item w-100" style="position: absolute; left: 0%; top: 0px;">
        <div class="row gap-20">
            @if (!Auth::user()->EnhancedAuthMethod)
            <div class="col-md-6">
                <div class="alert alert-warning">
                    <span>You haven't set the Google 2FA yet. Click <a href="{{ route('setting.index') }}">here</a> to setup.</span>
                </div>
            </div>
            <div class="col-md-6"></div>
            @endif
            <div class="col-md-3">
                <div class="layers bd bgc-white p-20">
                    <div class="layer w-100 mB-10">
                        <h6 class="lh-1">My Access Right</h6>
                    </div>
                    <div class="layer w-100">
                        <div class="peers ai-sb fxw-nw">
                            <div class="peer peer-greed">
                            </div>
                            <div class="peer">
                            <a href="{{ route('useraccess.show', Auth::user()->id) }}">
                                <span class="d-ib lh-0 va-m fw-600 bdrs-10em pX-15 pY-15 bgc-green-50 c-green-500">{{ $access_right_count }}</span>
                            </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="masonry-item col-md-6" style="position: absolute; left: 0%; top: 1021px;">
        <div class="bd bgc-white">
            <div class="layers">
                <div class="layer w-100 p-20">
                    <h6 class="lh-1">Current Pending Request</h6>
                </div>
                <div class="layer w-100">
                    <div class="bgc-light-blue-500 c-white p-20">
                        <div class="peers ai-c jc-sb gap-40">
                            <div class="peer peer-greed">
                                <h5>Pending Requests</h5>
                                <p class="mB-0">Untill today</p>
                            </div>
                            <div class="peer">
                                <h3 class="text-right">{{ $pending_request }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive p-20">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="bdwT-0">Request</th>
                                    <th class="bdwT-0">Request date</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($pending_records as $pending_record)
                                <tr>
                                    <td class="fw-600"><a href="{{ route('rq.detail', $pending_record->id) }}">{{ $pending_record->svc_equip_item->name }}</td>
                                    <td>{{ $pending_record->created_at  }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="ta-c bdT w-100 p-20">
                <a href="{{ route('rq.status', ['mode' => 'me']) }}">Check all the request</a>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
