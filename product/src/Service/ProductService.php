<?php
/**
 * Created by Artem Holovanov.
 * Date: 20.08.2025 19:05.
 */

declare(strict_types=1);

namespace App\Service;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Uid\Uuid;

class ProductService
{
    public function __construct(
        private EntityManagerInterface $em,
        private ProductRepository $repository
    ) {}

    public function create(Product $product): Product
    {
        $this->em->persist($product);
        $this->em->flush();
        return $product;
    }

    public function update(): void
    {
        $this->em->flush();
    }

    public function getAll(): array
    {
        return $this->repository->findAll();
    }

    public function get(Uuid $id): ?Product
    {
        return $this->repository->find($id);
    }
}