@extends('layouts.backend')

@php
    session()->put('header','Payment Transaction');
@endphp

@section('content')

                           <div class="card-body pb-0">
                                <div class="table-responsive">
                                    <table id="example3" class="display mb-3" style="min-width: 845px">
                                        <thead>
                                            <tr>
                                                <th>Transaction ID</th>
                                                <th>Date/Time</th>
                                                <th>Artist</th>
                                                <th>Client</th>
                                                <th>Total Amount</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>KFSDSKFWR55KFR</td>
                                                <td><strong>23 Apr 2021 / 09:30 AM</strong></td>
                                                <td><strong>Romaienia Jois</strong></td>
                                                <td><img class="rounded-circle" width="35" src="images/photo4.png" alt=""> Teresa Misty</td>
                                                <td>$ 30.06</td>
                                                <td>
                                                    <div class="d-flex">
                                                        <a href="payment-detail" class="btn btn-primary shadow btn-xs sharp me-1">View Detail</a>
                                                    </div>                                              
                                                </td>                                               
                                            </tr>
                                            <tr>
                                                <td>KFSDSKFWR55KFR</td>
                                                <td><strong>23 Apr 2021 / 09:30 AM</strong></td>
                                                <td><strong>Romaienia Jois</strong></td>
                                                <td><img class="rounded-circle" width="35" src="images/photo4.png" alt=""> Teresa Misty</td>
                                                <td>$ 30.06</td>
                                                <td>
                                                    <div class="d-flex">
                                                        <a href="payment-detail" class="btn btn-primary shadow btn-xs sharp me-1">View Detail</a>
                                                    </div>                                              
                                                </td>                                               
                                            </tr>
                                            <tr>
                                                <td>KFSDSKFWR55KFR</td>
                                                <td><strong>23 Apr 2021 / 09:30 AM</strong></td>
                                                <td><strong>Romaienia Jois</strong></td>
                                                <td><img class="rounded-circle" width="35" src="images/photo4.png" alt=""> Teresa Misty</td>
                                                <td>$ 30.06</td>
                                                <td>
                                                    <div class="d-flex">
                                                        <a href="payment-detail" class="btn btn-primary shadow btn-xs sharp me-1">View Detail</a>
                                                    </div>                                              
                                                </td>                                               
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
        @endsection
