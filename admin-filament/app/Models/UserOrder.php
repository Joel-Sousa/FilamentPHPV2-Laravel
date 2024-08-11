<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;


class UserOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_code',
        'user_id'
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function orderTotal(): Attribute
    {
        return new Attribute(fn($attr) => $this->items->sum('order_value'));
    }
}
