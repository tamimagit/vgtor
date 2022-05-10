<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MobileBanking extends Model
{
    protected $table    = 'mobile_bankings';
    public $timestamps  = false;
    public $appends     = ['image_url'];

    public function getImageUrlAttribute()
    {
        return url('/').'/public/front/images/mobile_bankings/'.$this->attributes['image'];
    }
}
