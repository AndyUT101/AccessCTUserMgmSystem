@extends('layouts.auth')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 col-md-offset-2">
            <div class="panel panel-default">
                <h4>2-Step Verification</h4>
                @if ($errors->has('message') > 0)

                <div class="alert alert-danger">
                    <span>{{ $errors->first('message') }}</span>
                </div>
                @endif

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('2fa') }}">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="one_time_password" class="control-label">Please enter your One Time Password</label>

                            <div>
                                <input id="one_time_password" type="number" class="form-control" name="one_time_password" maxlength="6" size="6" required autofocus>
                            </div>
                        </div>

                        <div class="form-group">
                            <div>
                                <button type="submit" class="btn btn-secondary">
                                    Login
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection