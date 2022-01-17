<?php


namespace App\Repository;


use App\Models\Order\Order;
use App\Models\Order\OrderDiscount;
use App\Models\Order\OrderProduct;

class OrderRepository implements OrderInterface
{

    public function findById(int $id): ?Order
    {
        return Order::find($id);
    }

    public function create(array $data): Order
    {
        $order=Order::create($data['order']);

        foreach ($data['orderProduct'] as $item) {
            OrderProduct::create(array_merge($item,['order_id'=>$order->id]));
        }

        return $order;
    }

    public function createForProduct(array $data): OrderProduct
    {
        return OrderProduct::create($data);
    }

    public function update(int $id, array $data): Order
    {
        Order::where('id', $id)->update($data);
        return $this->findById($id);
    }

    public function remove(int $id): bool
    {
        $order = Order::where('id', $id)->delete();
        OrderProduct::where('order_id', $id)->delete();
        OrderDiscount::where('order_id', $id)->delete();
        return $order;
    }
}
