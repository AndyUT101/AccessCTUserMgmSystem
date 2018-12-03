@extends('layouts.panel')

@section('content')
<div class="container-fluid">
    <p><a href="{{ route('rq.index', $dataset['type_item']->keyname) }}"><i class="ti-angle-left"></i> Return Request</a></p>
    <div class="row">
        <div class="col-md-12">
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                <div style="margin-bottom: 1rem;">
                    Action: <a href="{{ route('rq.edit', [
                    $dataset['type_item']->keyname, $dataset['request_item']->id
                    ]) }}">Edit</a> | 
                    <form action="{{ route('rq.destroy', [
                    $dataset['type_item']->keyname, $dataset['request_item']->id
                    ]) }}" method="post" style="display:inline-block">@csrf<input name="_method" type="hidden" value="DELETE">
                    <button type="submit" class="btn btn-link" style="padding: 0;margin-top: -4px;">Remove</button>
                    </form>
                </div>
                <h4 class="c-grey-900 mB-20">{{ $dataset['request_item']->name }}</h4>
                <div>
                <p><strong>Request name</strong> : {{ $dataset['request_item']->name }}</p>

                <p><strong>Request description</strong> : </p>
                <p>{!! nl2br($dataset['request_item']->desc) !!}</p>

                <p><strong>Request parameters</strong></p> 
                @foreach ($dataset['request_item']->require_parameters as $key=>$val)
                <li><span class="badge badge-primary">{{ $key }}</span> <i class="ti-arrow-right"></i> {{ $val }}</li>
                @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection