@extends('layouts.panel')

@section('content')
<div class="container-fluid">
    <h4 class="c-grey-900 mT-10 mB-30">Create Categories</h4>
    <div class="row">
        <div class="col-md-12">
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
            {!! form($form) !!}
            </div>
        </div>
    </div>
</div>
@endsection