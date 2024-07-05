<?php

namespace App\Models;

use App\Models\Item;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'booking_code',
        'number_phone',
        'with_driver',
        'with_delivery',
        'start_date',
        'end_date',
        'address',
        'city',
        'status',
        'payment_method',
        'payment_status',
        'payment_url',
        'total_price',
        'item_id', // item
        'user_id', // user
    ];

    protected $casts  = [
        'start_date' => 'date:d-m-Y',
        'end_date' => 'date:d-m-Y',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
