<?php

namespace App\Controller;

use App\Dto\ProductCreateDto;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Service\Attribute\Required;

#[Route('/api/v1/products')]
class ProductController extends AbstractController {

    private readonly ProductRepository $productRep;

    #[Required]
    public function __construct(ProductRepository $productRep) {
        $this->productRep = $productRep;
    }

    #[Route('/{productId}', methods: "GET", name: "get_profuct_by_id")]
    public function getProductById(int $productId) : Response {
        $product = $this->productRep->find($productId);
        return $this->json(['product' => $product]);
    }

    #[Route(methods: "POST", name: 'create_new_product')]
    public function createNewProduct(#[MapRequestPayload] ProductCreateDto $dto) : Response {
        $raw = $dto->toProduct();
        $this->productRep->create($raw);
        return $this->json(['product_id' => $raw->getProductId()]);
    }
}