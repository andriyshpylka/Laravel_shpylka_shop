<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    protected $fillable=['name','code','description','image','price','category_id','hit','new','recommend','count'];

    public function GetCategory(){
        $category=Category::where($this->category_id,'id')->first();
        return $category;
    }

    public function isAvailable(){
        return $this->count>0 && !$this->trashed();
    }
    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function getPriceForCount(){
    	if(!is_null($this->pivot))
    	{
    		 return $this->pivot->count * $this->price;
    	}
    	 return  $this->price;

    }
    public function setNewAttribute($value){
        $this->attributes['new']=$value==='on'? 1:0;
    }
    public function setHitAttribute($value){
        $this->attributes['hit']=$value==='on'? 1:0;
    }
    public function setRecommendAttribute($value){
        $this->attributes['recommend']=$value==='on'? 1:0;
    }
    public function isHit(){
        return $this->hit===1;
    }
    public function isNew(){
        return $this->new===1;
    }
    public function isRecommend(){
        return $this->recommend===1;
    }

    public function scopeHit($query){
        return $query->where('hit',1);
    }
    public function scopeNew($query){
        return $query->where('new',1);
    }
    public function scopeRecommend($query){
        return $query->where('recommend',1);
    }



}






