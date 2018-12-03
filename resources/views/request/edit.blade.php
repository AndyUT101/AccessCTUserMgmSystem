@extends('layouts.panel')

@section('content')
<div class="container-fluid">
    <p><a href="{{ route('rq.show', [$dataset['type_item']->keyname, $dataset['request_item']->id]) }}"><i class="ti-angle-left"></i> Return {{ $dataset['request_item']->name }}</a></p>
    <div class="row">
        <div class="col-md-12">
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                <h4 class="c-grey-900 mB-20">Update request</h4>
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
                <form method="post" action="{{ route('rq.update', [$dataset['type_item']->keyname, $dataset['request_item']->id]) }}">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <label for="exampleInputEmail1">Name</label>
                        <input type="text" class="form-control" name="name" value="{{ old('name', $dataset['request_item']->name) }}" id="name" placeholder="Enter name"> 
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Description</label>
                        <textarea type="text" class="form-control" name="desc" id="desc" placeholder="Enter description" rows="4">{{ old('desc', $dataset['request_item']->desc) }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection