<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
class Post extends Model
{
    protected $table = 'posts';
    
    
    protected $primarykey = 'id';
    
      protected $appends = ['url'];
    
    public function getUrlAttribute(){
        return url('uploads/artist/');
    }
    
    protected $fillable  = ['user_id','type','upload','videos','title','description'];
    
    
    
    public function all_posts(){
        return $this->hasMany(\App\Upload::class, 'post_id');
    }
    
}
