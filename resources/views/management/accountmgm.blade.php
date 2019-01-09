@extends('layouts.panel')

@section('content')
<div class="container-fluid">
    <h4 class="c-grey-900 mT-10 mB-30">Account management</h4>
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
                            <td><span class="badge badge-danger"></span></td>
                            <td>Termination / Delete Account / Disable Account</td>
                            <td><button type="button" class="btn btn-danger">Request</button></td>
                        </tr>
                        <tr>
                            <td><span class="badge badge-danger"></span></td>
                            <td>Request New Account (For Branch Manager/ Head of Department)</td>
                            <td><button type="button" class="btn btn-danger">Request</button></td>
                        </tr>
                        <tr>
                            <td><span class="badge badge-danger"></span></td>
                            <td>Enable Account</td>
                            <td><button type="button" class="btn btn-danger">Request</button></td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
@endsection