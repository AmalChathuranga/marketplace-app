<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable =['name','slug','description','image','price','quantity','is_active'];

    //seller relationship

    public function sellers() :BelongsToMany
    {
        return $this->belongsToMany(Seller::class,'seller_products')->withTimestamps()->withPivot('quantity');
    }
}
