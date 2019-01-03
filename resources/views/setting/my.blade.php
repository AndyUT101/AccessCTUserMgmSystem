@extends('layouts.panel')

@section('content')
<div class="container-fluid">
    <h4 class="c-grey-900 mT-10 mB-30">My Setting</h4>
    <div class="row">
        <div class="col-md-12">
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
            <div class="row gap-20">
            <div class="col-md-4">
            
                <p>2-step authentication : <strong>@if (Auth::user()->EnhancedAuthMethod) <span class="c-green-500">On</span> @else <span class="c-red-500">Off</span> @endif</strong></p>
            </div>
            <div class="col-md-2">
                @if (Auth::user()->EnhancedAuthMethod)
                <a class="btn btn-info" href="{{ route('user.2fa') }}" role="button">Renew Token</a> 
                @else
                <a class="btn btn-success" href="{{ route('user.2fa') }}" role="button">Enable 2FA auth</a> 
                @endif
            </div>
            <div class="col-md-10"></div>
            <div class="col-md-4">
            <h4>Other user setting</h4>
            {!! form($form) !!}
            </div>

            </div>
            </div>
        </div>
    </div>
</div>
@endsection