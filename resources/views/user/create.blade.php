@extends('layouts.panel')

@section('content')
<div class="col-md-12">
    <div class="bgc-white p-20 bd">
        <h6 class="c-grey-900">Add User</h6>
        <div class="mT-30">
            <form method="post" action="{{ route('user.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="name">User name</label>
                        <input class="form-control" id="name" name="name" placeholder="User name" type="text" value="{{ old('name') }}">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="password">Password</label>
                        <input class="form-control" id="password" name="password" placeholder="Password" type="password" value="{{ old('password') }}">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="password-confirm">Repeat Password</label>
                        <input class="form-control" id="password-confirm" name="password_confirmation" placeholder="Repeat password" type="password" value="{{ old('password-confirm') }}">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="email">Email</label>
                        <input class="form-control" id="email" name="email" placeholder="Email address" type="email" value="{{ old('email') }}">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="usertype">User Type</label>
                        <div>
                            <select name="usertype" aria-controls="dataTable" class="">
                                <option value=""></option>
                            </select>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>
@endsection