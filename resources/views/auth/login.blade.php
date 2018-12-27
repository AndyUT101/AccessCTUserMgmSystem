@extends('layouts.auth')

@section('content')
      <h4 class="fw-300 c-grey-900 mB-40">Login</h4>
      <form method="POST" action="{{ route('login') }}">
      @csrf
        <div class="form-group">
            <label class="text-normal text-dark">{{ __('Username') }}</label> <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
            placeholder="Username" required autofocus>
            @if ($errors->has('name'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('name') }}</strong>
            </span>
            @endif
        </div>
        <div class="form-group">
            <label class="text-normal text-dark">Password</label> <input type="password" id="password" name="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
            placeholder="Password" required>
            @if ($errors->has('password'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
            @endif
        </div>
        <div class="form-group">
          <div class="peers ai-c jc-sb fxw-nw">
            <div class="peer">
              <div class="checkbox checkbox-circle checkbox-info peers ai-c"><input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}
                  name="inputCheckboxesCall" class="peer"> <label for="inputCall1" class="peers peer-greed js-sb ai-c"><span
                    class="peer peer-greed">Remember Me</span></label></div>
            </div>
            <div class="peer"><button type="submit" class="btn btn-danger">Login</button></div>
          </div>
        </div>
        <div class="form-group">
            <a href="{{ url('password/reset') }}" alt="Forget password">Forget password</a>
        </div>
      </form>
@endsection