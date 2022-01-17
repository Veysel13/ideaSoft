<?php


namespace App\Repository;


use App\Models\Product\Product;

interface ProductInterface
{

    public function findById(int $id): ?Product;

    public function create(array $data): Product;

    public function update(int $id, array $data): Product;

    public function remove(int $id): bool;

}
