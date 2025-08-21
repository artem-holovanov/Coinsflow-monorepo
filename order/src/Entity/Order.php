<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\Type('string')]
    #[Assert\Length(max: 50)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[ORM\Column(type: Types::STRING, length: 50)]
    protected ?string $customerName = null;

    #[Assert\Type('integer')]
    #[Assert\Positive]
    #[Assert\NotNull]
    #[ORM\Column(type: Types::INTEGER)]
    protected ?int $quantityOrdered = null;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Product $product = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCustomerName(): ?string
    {
        return $this->customerName;
    }

    public function setCustomerName(?string $customerName): Order
    {
        $this->customerName = $customerName;
        return $this;
    }

    public function getQuantityOrdered(): ?int
    {
        return $this->quantityOrdered;
    }

    public function setQuantityOrdered(?int $quantityOrdered): Order
    {
        $this->quantityOrdered = $quantityOrdered;
        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): Order
    {
        $this->product = $product;
        return $this;
    }
}
