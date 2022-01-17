<?php


namespace App\Models\Campaign;


use App\Models\Order\Order;
use App\Models\Order\OrderProduct;
use App\Repository\OrderRepository;

class CategoryDiscount
{

    private $orderRepository;
    private $order;
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

        return true;
    }

    public function getDiscount()
    {
        return CampaignDb::whereIn('type',['category_product_discount','category_cheapest_discount'])
            ->where('status',1)
            ->get();
    }

    public function getName()
    {
        return 'Kategori İndirimi';
    }

    public function getKey()
    {
        return 'category_discount';
    }

    public function getType()
    {
        return 'category_discount';
    }

    public function getAmount()
    {

        $discount=0;
        foreach ($this->discount as $item){



            if ($item->type=='category_product_discount'){
                $categoryProductcount=OrderProduct::join('products','products.id','=','order_products.product_id')
                    ->where('order_id',$this->order->id)
                    ->where('products.category_id',$item->type_id)
                    ->sum('quantity');

                if ($categoryProductcount>=$item->quantity){
                    $product=OrderProduct::join('products','products.id','=','order_products.product_id')
                        ->where('order_id',$this->order->id)
                        ->where('products.category_id',$item->type_id)
                        ->first();

                    if ($product)
                        $discount += $product->unit_price;
                }
            }else if ($item->type=='category_cheapest_discount'){
                $categoryProductcount=OrderProduct::join('products','products.id','=','order_products.product_id')
                    ->where('order_id',$this->order->id)
                    ->where('products.category_id',$item->type_id)
                    ->sum('quantity');


                if ($categoryProductcount>=$item->quantity){
                    $product=OrderProduct::join('products','products.id','=','order_products.product_id')
                        ->where('order_id',$this->order->id)
                        ->where('products.category_id',$item->type_id)
                        ->orderBy('unit_price','ASC')
                        ->first();

                    if ($product)
                    $discount += $product->unit_price * ($item->discount / 100);
                }
            }

        }

        return -$discount;
    }

}
