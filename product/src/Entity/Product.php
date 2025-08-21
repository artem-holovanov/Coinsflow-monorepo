<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use CommonBundle\Entity\Product as BaseProduct;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product extends BaseProduct
{
}