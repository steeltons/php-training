<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use Generator;

#[Entity(repositoryClass : ProductRepository::class)]
#[Table(name : "product")]
class Product {

    #[Id]
    #[GeneratedValue(strategy : 'IDENTITY')]
    #[Column(name: 'product_id')]
    private ?int $productId;
    #[Column(name: "name", nullable : false, length : 255)]
    private ?string $name;
    #[Column(name : "price")]
    private ?int $price;

    public function __construct(?int $productId = null, 
                                ?string $name = 'DEFAULT_NAME', 
                                ?int $price = 0) {
        $this->productId = $productId;
        $this->name = $name;
        $this->price = $price;
    }

    public function setProductId(?int $productId) {
        $this->productId = $productId;
    }

    public function setName(?string $name) {
        $this->name = $name;
    }

    public function setPrice(?int $price) {
        $this->price = $price;
    }

    public function getProductId() : ?int {
        return $this->productId;
    }

    public function getName() : ?string {
        return $this->name;
    }

    public function getPrice() : ?int {
        return $this->price;
    }
}