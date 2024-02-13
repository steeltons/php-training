<?php

namespace App\Dto;

use App\Entity\Product;

readonly class ProductCreateDto {

    public ?string $name;
    public ?int $price;

    public function __construct(?string $name, ?int $price) {
        $this->name = $name;
        $this->price = $price;
    }

    public function toProduct() : Product {
        return new Product(null, $this->name, $this->price);
    }
}