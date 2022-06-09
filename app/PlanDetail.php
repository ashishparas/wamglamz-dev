<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlanDetail extends Model
{
   protected $table = "plan_details";
   
   
   
   protected $primaryKey = "id";
   
   
   
   protected $fillable = ['plan_type','title','description','advantages'];
   
   
   public function getAdvantagesAttribute($value){
       return explode(',', $value);
   }
   
   
}
