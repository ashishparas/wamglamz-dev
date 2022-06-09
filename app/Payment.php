<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\ClientDiscount;
class Payment extends Model
{
    use LogsActivity;
    

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'payments';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'name', 'card_no','cvv' ,'zipcode', 'expiry_month', 'expiry_date', 'set_default', 'status','payment_token'];

    

    /**
     * Change activity log event description
     *
     * @param string $eventName
     *
     * @return string
     */
    public function getDescriptionForEvent($eventName)
    {
        return __CLASS__ . " model has been {$eventName}";
    }
    
    // public function getCardNoAttribute($value){
    //     return ($value)? base64_decode($value):'';
    // }
    
    public function PromoCode(){
        return $this->hasOne(ClientDiscount::class, 'user_id','user_id')->select('user_id','percentage');
    }
    
}
