<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
class ChargePayment extends Model
{
   use LogsActivity;
   
   
   protected $table = "charge_payment";
   
   
   protected $fillable = ['user_id','charge_id','booking_id','customer_id','card_id','amount','currency','brand','network_status','receipt_url'];
   
   
   protected $primaryKey = "id";
}
