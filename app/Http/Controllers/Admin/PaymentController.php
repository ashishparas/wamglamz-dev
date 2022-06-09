<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentController extends Controller {

    public function payment(){
        return view('admin.payment');
    }
    public function payment_detail(){
    	return view('admin.payment-detail');
    }

   

}
