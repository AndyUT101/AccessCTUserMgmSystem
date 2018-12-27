@extends('layouts.panel')

@section('content')
<div class="container-fluid">
    <p><a href="{{ route('branchdept.index') }}"><i class="ti-angle-left"></i> Return Branch and Department</a></p>
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
                <div style="margin-bottom: 1rem;">
                    Action: <a href="{{ route('branchdept.edit', $dataset->id) }}">Edit</a> | 
                    <form action="{{ route('branchdept.destroy', $dataset->id) }}" method="post" style="display:inline-block">@csrf<input name="_method" type="hidden" value="DELETE">
                    <button type="submit" class="btn btn-link" style="padding: 0;margin-top: -4px;">Remove</button>
                    </form>
                </div>
                <h4 class="c-grey-900 mB-20">{{ $dataset->name }}</h4>
                <div>
                <p><strong>Request name</strong> : {{ $dataset->name }}</p>

                <p><strong>Request description</strong> : </p>
                <p>{!! nl2br($dataset->desc) !!}</p>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection