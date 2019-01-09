@extends('layouts.panel')

@section('content')
<div class="container-fluid">
    <h4 class="c-grey-900 mT-10 mB-30">Request tray</h4>
    <p>Request tray</p>
    <div class="row">
        <div class="col-md-12">
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                <!-- <h4 class="c-grey-900 mB-20">Simple Table</h4> -->
                <p>Action: <a href="#">Process multple items</a></p>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">User</th>
                            <th scope="col">Date</th>
                            <th scope="col">Category</th>
                            <th scope="col">Request</th>
                            <th scope="col">Process</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>b01s01</td>
                            <td>2 hours ago</td>
                            <td><span class="badge badge-danger">Reporting</span></td>
                            <td>MIS Report / Data Extraction</td>
                            <td><button type="button" class="btn btn-danger">Approve</button> <button type="button" class="btn btn-secondary">Reject</button></td>
                        </tr>
                        <tr>
                            <td>b01s01</td>
                            <td>2 hours ago</td>
                            <td><span class="badge badge-danger">Reporting</span></td>
                            <td>User Report</td>
                            <td><button type="button" class="btn btn-danger">Approve</button> <button type="button" class="btn btn-secondary">Reject</button></td>
                        </tr>
                        <tr>
                            <td>b01s01</td>
                            <td>2 hours ago</td>
                            <td><span class="badge badge-danger">Software</span></td>
                            <td>Visual Studio 2018</td>
                            <td><button type="button" class="btn btn-danger">Approve</button> <button type="button" class="btn btn-secondary">Reject</button></td>
                        </tr>
                        <tr>
                            <td>b01s01</td>
                            <td>2 hours ago</td>
                            <td><span class="badge badge-danger">Account</span></td>
                            <td>Request New Account</td>
                            <td><button type="button" class="btn btn-danger">Approve</button> <button type="button" class="btn btn-secondary">Reject</button></td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
@endsection