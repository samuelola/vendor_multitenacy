<?php

namespace App\Interface;

interface ProductInterface{

    public function createProduct(array $productData);
    public function updateProduct(int $id,array  $productData);
    public function deleteProduct($productData);
}