<?php


namespace App\Repository;


use App\Models\Order\Order;
use App\Models\Order\OrderProduct;

interface OrderInterface
{

    public function findById(int $id): ?Order;

    public function create(array $data): Order;

    public function createForProduct(array $data): OrderProduct;

    public function update(int $id, array $data): Order;

    public function remove(int $id): bool;
}
