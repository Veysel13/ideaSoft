<?php


namespace App\Models\Order;


use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{

    protected $fillable=[
        'order_id',
        'product_id',
        'quantity',
        'unit_price',
        'total'
    ];

}
