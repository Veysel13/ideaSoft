<?php


namespace App\Helpers;


use App\Repository\ProductRepository;

class Ordered
{
    private $errorMessage;
    private $productRepository;

    public function __construct()
    {
        $this->productRepository = new ProductRepository();
    }

    public function is($orderData){

        foreach ($orderData['orderProduct'] as $item) {

            $product = $this->productRepository->findById($item['product_id']);

            if (!$product) {
                $this->errorMessage='Ürün bulunamadı';
                return false;
            }

            if ($product->stock < $item['quantity']) {
                $this->errorMessage='Ürün stoğu yetersiz';
                return false;
            }
        }

        return true;
    }

    public function getErrorMessage()
    {
        return $this->errorMessage;
    }
}
