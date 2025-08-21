<?php

namespace App\Entity;

use CommonBundle\Entity\Product as BaseProduct;
use CommonBundle\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product extends BaseProduct
{
}