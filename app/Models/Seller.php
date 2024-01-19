<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Seller extends Authenticatable
{
    use HasApiTokens, HasFactory, HasFactory, Notifiable;

    protected $fillable =['name','email','password','address','contact_no'];

    protected $hidden = [
        'password',
     
    ];

    protected $casts = [
       
        'password' => 'hashed',
    ];

    //product relationship

    public function products() :BelongsToMany
    {
        return $this->belongsToMany(Product::class,'seller_products','seller_id','product_id');
    }
}
