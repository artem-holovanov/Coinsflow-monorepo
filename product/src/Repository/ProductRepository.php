<?php
/**
 * Created by Artem Holovanov.
 * Date: 21.08.2025 14:52.
 */

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Product;
use CommonBundle\Repository\AbstractProductRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends AbstractProductRepository<Product>
 */
class ProductRepository extends AbstractProductRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }
}