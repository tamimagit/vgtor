<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MobileDate extends Model
{
    protected $fillable = ['booking_id', 'date'];

    public function getLowestDate($bookingId) {
        return MobileDate::where('booking_id', $bookingId)->orderBy('date', 'asc')->first()->date;
    }
}
