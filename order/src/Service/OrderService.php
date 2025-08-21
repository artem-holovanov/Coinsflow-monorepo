<?php
/**
 * Created by Artem Holovanov.
 * Date: 20.08.2025 19:05.
 */

declare(strict_types=1);

namespace App\Service;

use App\Entity\Order;
use App\Repository\OrderRepository;
use CommonBundle\ValueObject\OrderValue;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Uid\Uuid;

class OrderService
{
    public function __construct(
        private EntityManagerInterface $em,
        private OrderRepository $repository,
    ) {}

    public function create(Order $order): Order
    {
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

    public function get(Uuid $id): ?Order
    {
        return $this->repository->find($id);
    }
}