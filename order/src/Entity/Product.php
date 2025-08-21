<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use CommonBundle\Entity\Product as BaseProduct;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product extends BaseProduct
{
    /**
     * @var Collection<int, Order>
     */
    #[ORM\OneToMany(
        targetEntity: Order::class,
        mappedBy: 'product',
    )]
    private Collection $orders;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
    }

    /**
     * @return Collection<int, Order>
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function setId(Uuid $id): Product
    {
        $this->id = $id;
        return $this;
    }
}