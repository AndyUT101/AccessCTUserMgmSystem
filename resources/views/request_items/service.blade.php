@extends('layouts.panel')

@section('content')
<div class="container-fluid">
    <h4 class="c-grey-900 mT-10 mB-30">Request IT service</h4>
    <p><a href="#">Request history</a> | In progress request <a href="#" class="badge badge-danger">9</a></p>
    <div class="row">
        <div class="col-md-12">
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                <!-- <h4 class="c-grey-900 mB-20">Simple Table</h4> -->
                <p>Action: <a href="#">Request multple items</a></p>
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
                            <td><span class="badge badge-danger">Reporting</span></td>
                            <td>MIS Report / Data Extraction</td>
                            <td><button type="button" class="btn btn-danger">Request</button></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>User Report</td>
                            <td><button type="button" class="btn btn-danger">Request</button></td>
                        </tr>
                        <tr>
                            <td><span class="badge badge-danger">Software</span></td>
                            <td>Visual Studio 2018</td>
                            <td><button type="button" class="btn btn-danger">Request</button></td>
                        </tr>
                        <tr>
                            <td><span class="badge badge-danger">Account</span></td>
                            <td>Request New Account</td>
                            <td><button type="button" class="btn btn-danger" disabled>Request</button></td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
@endsection