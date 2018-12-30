@extends('layouts.auth')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <h4>Set up Google Authenticator</h4>
                @if ($show_error)
                <div class="alert alert-danger">
                    <ul>
                        <li>PIN invalid.</li>
                    </ul>
                </div>
                @endif
                <div class="panel-body" style="text-align: center;">
                    <p>Set up your two factor authentication by scanning the barcode below. Alternatively, you can use the code <strong>{{ $secret }}</strong></p>
                    <div>
                        <img src="{{ $QR_Image }}">
                    </div>
                    <div>
                        {!! form($form) !!}
                    </div>
                    <p>Relogin is required when the auth once enabled.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection