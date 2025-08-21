<?php
/**
 * Created by Artem Holovanov.
 * Date: 20.08.2025 19:05.
 */

declare(strict_types=1);

namespace App\Service;

use App\Entity\Product;
use App\Repository\ProductRepository;
use CommonBundle\ValueObject\ProductValue;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Uid\Uuid;

class ProductService
{
    public function __construct(
        private EntityManagerInterface $em,
        private ProductRepository $repository,
        private MessageBusInterface $messageBus,
    ) {}

    public function create(Product $product): Product
    {
        $this->em->beginTransaction();
        try {
            $product->setId(Uuid::v7());
            $this->em->persist($product);
            $this->em->flush();

            $this->dispatch($product);

            $this->em->commit();
        } catch (\Throwable $e) {
            $this->em->rollback();
            throw $e;
        }

        return $product;
    }

    public function getAll(): array
    {
        return $this->repository->findAll();
    }

    public function get(Uuid $id): ?Product
    {
        return $this->repository->find($id);
    }

    private function dispatch(Product $product): void
    {
        $productValue = ProductValue::fromEntity($product);
        $envelope = new Envelope($productValue);

        $this->messageBus->dispatch($envelope);
    }
}