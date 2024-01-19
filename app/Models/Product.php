<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable =['name','slug','description','image','price','quantity'];

    //seller relationship

    public function sellers() :BelongsToMany
    {
        return $this->belongsToMany(Seller::class,'seller_products','product_id','seller_id');
    }
}
