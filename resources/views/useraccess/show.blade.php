@extends('layouts.panel')

@section('content')
<div class="container-fluid">
    <h4 class="c-grey-900 mT-10 mB-30">User access right - {{ $user->name }}</h4>
    <div class="row">
        <div class="col-md-12">
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                <!-- <h4 class="c-grey-900 mB-20">Simple Table</h4> -->
                <p>Record count: {{ $dataset->total() }}</p>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Apply date</th>
                            <th scope="col">User access right</th>
                            <th scope="col">Status</th>
                            <th scope="col">Expire date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dataset as $item)
                        <tr>
                            <td></td>
                            <td>{{ $item->created_at }}</td>
                            <td>{{ $item->svc_equip_item->name }}
                            @foreach ($item->require_parameters as $key => $value)
                            <li>{{ $key }} || {{ $value }}</li>
                                @endforeach</td>
                            <td>{{ $item->StatusText }}</td>
                            <td>{{ $item->request_enddate }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                {{ $dataset->links() }}
            </div>
        </div>
    </div>
</div>
@endsection