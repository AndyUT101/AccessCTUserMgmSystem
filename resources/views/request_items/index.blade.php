@extends('layouts.panel')

@section('content')
<div class="container-fluid">
    <h4 class="c-grey-900 mT-10 mB-30">Request computer equipment</h4>
    <div class="row">
        <div class="col-md-12">
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                <!-- <h4 class="c-grey-900 mB-20">Simple Table</h4> -->
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col" width="50">Category</th>
                            <th scope="col">Item</th>
                            <th scope="col">Request</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><span class="badge badge-danger">Desktop PC</span></td>
                            <td>HP ProDesk 600 G3 SFF (CPU: i5 6300 3.2Ghz)</td>
                            <td><button type="button" class="btn btn-danger">Request</button></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>HP ProDesk 800 G3 SFF (CPU: i7 7700 3.4Ghz)</td>
                            <td><button type="button" class="btn btn-danger">Request</button></td>
                        </tr>
                        <tr>
                            <td><span class="badge badge-danger">Software</span></td>
                            <td>Visual Studio 2018</td>
                            <td><button type="button" class="btn btn-danger">Request</button></td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
@endsection