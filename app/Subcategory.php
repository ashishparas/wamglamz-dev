<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use \App\ArtistService;
use App\Main_category;
class Subcategory extends Model
{
    use LogsActivity;
    

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'subcategories';

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
    protected $fillable = ['category_id', 'title', 'image'];

    

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
    
    public function SubCategory(){
        return $this->hasOne(ArtistService::class, 'id', 'sub_category_id')->select('id','title');
    }
    
    // below for fetching categories in admin panel
    
    public function category(){
        return $this->hasOne(Main_category::class, 'id', 'category_id')->select('id','title');
    }
    
}
