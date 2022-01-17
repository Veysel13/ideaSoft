<?php


namespace App\Repository;


use App\Models\Product\Product;

class ProductRepository implements ProductInterface
{

    public function findById(int $id): ?Product
    {
        return Product::find($id);
    }

    public function create(array $data): Product
    {
        return Product::create($data);
    }

    public function update(int $id, array $data): Product
    {
        Product::where('id', $id)->update($data);
        return $this->findById($id);
    }

    public function remove(int $id): bool
    {
        return Product::where('id', $id)->delete();
    }
}
