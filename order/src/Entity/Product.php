<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use CommonBundle\Entity\Product as BaseProduct;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Uid\Uuid;

#[Groups(['order:read'])]
#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product extends BaseProduct
{
    public function setId(Uuid $id): Product
    {
        $this->id = $id;
        return $this;
    }
}