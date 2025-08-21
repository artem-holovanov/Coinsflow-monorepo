<?php
/**
 * Created by Artem Holovanov.
 * Date: 20.08.2025 19:05.
 */

declare(strict_types=1);

namespace App\Service;

use App\Entity\Order;
use App\Entity\Product;
use App\Exception\OrderServiceException;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;

class OrderService
{
    public function __construct(
        private EntityManagerInterface $em,
        private OrderRepository $repository,
    ) {}

    /**
     * @param Order $order
     * @return Order
     * @throws OrderServiceException
     */
    public function create(Order $order): Order
    {
        $productEntity = $order->getProduct();
        if (!$productEntity instanceof Product || $order->getQuantityOrdered() > $productEntity->getQuantity()) {
            throw new OrderServiceException(
                sprintf(
                    'Ordered %d quantity exceeds %d available Product quantity.',
                    $order->getQuantityOrdered(),
                    $productEntity->getQuantity()
                )
            );
        }

        $productEntity->setQuantity($productEntity->getQuantity() - $order->getQuantityOrdered());

        $this->em->persist($order);
        $this->em->flush();

        return $order;
    }

    public function update(): void
    {
        $this->em->flush();
    }

    public function getAll(): array
    {
        return $this->repository->findAll();
    }

    public function get(int $id): ?Order
    {
        return $this->repository->find($id);
    }
}