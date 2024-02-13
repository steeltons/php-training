<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Error;

class ProductRepository extends ServiceEntityRepository {

    private readonly ObjectManager $manager;

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Product::class);
        $this->manager = $registry->getManager();
    }

    public function create(Product &$raw) {
        try {
            $this->manager->persist($raw);
            $this->manager->flush();
        } catch (Error $er) {
            throw $er;
        }
    } 
}