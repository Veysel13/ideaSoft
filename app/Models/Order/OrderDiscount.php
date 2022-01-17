<?php


namespace App\Models\Order;


use Illuminate\Database\Eloquent\Model;

class OrderDiscount extends Model
{
    protected $fillable=[
        'order_id',
        'name',
        'key',
        'total',
    ];
}
