<?php


namespace App\Models\Campaign;


use App\Models\Order\Order;
use App\Repository\OrderRepository;

class TotalDiscount
{

    private $orderRepository;
    private $order;
    protected $discount;
    protected $discountType;
    public function __construct(Order $order)
    {
        $this->orderRepository = new OrderRepository();
        $this->order = $order;
    }

    public function isUses()
    {
        $getDiscount = $this->getDiscount();

        if(!$getDiscount){
            return false;
        }

        $this->discount = $getDiscount;
        $this->discountType = $this->discount->discount_type;

        return true;
    }

    public function getDiscount()
    {
        return CampaignDb::where('type','order_discount')
            ->where('min_price','<=',$this->order->total)
            ->where('status',1)
            ->first();
    }

    public function getName()
    {
        return 'Sipariş İndirimi';
    }

    public function getKey()
    {
        return 'order_discount';
    }

    public function getType()
    {
        return 'order_discount';
    }

    public function getAmount()
    {
        $discount = $this->order->total * ($this->discount->discount/ 100);

        return -$discount;
    }
}
