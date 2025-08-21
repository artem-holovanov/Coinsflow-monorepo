<?php
/**
 * Created by Artem Holovanov.
 * Date: 21.08.2025 18:01.
 */

declare(strict_types=1);

namespace App\Service;

use App\Entity\Product;
use CommonBundle\ValueObject\ProductValue;
use Doctrine\ORM\EntityManagerInterface;

class ProductService
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    )
    {}

    public function persistProduct(ProductValue $productValue): void
    {
        $productEntity = new Product()
            ->setId($productValue->id())
            ->setName($productValue->name())
            ->setPrice($productValue->price())
            ->setQuantity($productValue->quantity());

        $this->entityManager->persist($productEntity);
        $this->entityManager->flush();
    }
}