@extends('layouts.backend')

@php
    session()->put('header','Payment Transaction');
@endphp

@section('content')

       
            
                <div class="row">
                    <div class="col-xl-12 col-xxl-12">
                        <div class="card">
                            <div class="card-header border-0 pb-0">
                                <h4 class="card-title">Invoice Detail</h4>
                                <div>
                                    <a class="btn btn-rounded btn-primary mt-0 px-5" href="javascript:void();">Download</a>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="invoice-list">
                                    <img alt="image" width="50" src="images/nails-img2.jpg">
                                    <div class="px-2">
                                        <p class="mb-0"><strong>Artist</strong></p>
                                        <h6 class="fs-16 font-w600 mb-0"><a href="page-invoices.html" class="text-black">Romaienia Jois</a></h6>
                                        <span class="fs-12">jois_official@gmail.com</span>
                                    </div>
                                    </div>
                             
                                <div class="invoice-list">
                                    <img alt="image" width="50" src="images/2.jpg">
                                    <div class="px-2">
                                        <p class="mb-0"><strong>Client</strong></p>
                                        <h6 class="fs-16 font-w600 mb-0"><a href="page-invoices.html" class="text-black">Teresa Misty</a></h6>
                                        <span class="fs-12">jois_official@gmail.com</span>
                                    </div>
                                </div>
                           
                                <div class="border-0 pb-0 px-4 mt-4">
                                    <h4 class="card-title pb-3">Receipt</h4>
                                    <h5>No. of Person: 02</h5>
                                    <div class="w-75">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-responsive-sm table-payment">
                                            <tbody>
                                                <tr>
                                                    <td>UV Gel Overlays...</td>
                                                    <td>X 2</td>
                                                    <td><strong>$ 10.02</strong></td>
                                                </tr>
                                                <tr>
                                                    <td>Dip Powder Nails</td>
                                                    <td>X 2</td>
                                                    <td><strong>$ 05.02</strong></td>
                                                </tr>
                                                <tr>
                                                    <td>Dip Powder Nails</td>
                                                    <td>X 2</td>
                                                    <td><strong>$ 10.02</strong></td>
                                                </tr>
                                                <tr>
                                                    <td>Service Tax</td>
                                                    <td>&nbsp;</td>
                                                    <td><strong>$ 5.00</strong></td>
                                                </tr>
                                                <tr class="bortop">
                                                    <td>Grand Total</td>
                                                    <td>&nbsp;</td>
                                                    <td><strong>$ 30.06</strong></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div> 
                                </div> 
                                </div>
                            </div>
                        </div>
                
                    </div>
                </div>
        
     
        @endsection
