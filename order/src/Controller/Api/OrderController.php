<?php
/**
 * Created by Artem Holovanov.
 * Date: 20.08.2025 19:03.
 */

declare(strict_types=1);

namespace App\Controller\Api;

use App\Entity\Order;
use App\Form\OrderType;
use App\Service\OrderService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

#[Route('/api/orders')]
class OrderController extends AbstractController
{
    public function __construct(
        private readonly OrderService $orderService,
    ) {}

    #[Route('', name: 'order_index', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $orders = $this->orderService->getAll();
        return $this->json(['data' => $orders], Response::HTTP_OK);
    }

    #[Route('', name: 'order_create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $order = new Order();
        $form = $this->createForm(OrderType::class, $order);
        $data = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);
        $form->submit($data);

        if (!$form->isValid()) {
            return $this->json([
                'errors' => $this->getFormErrors($form)
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $this->orderService->create($order);
        } catch (\Throwable $exception) {
            return $this->json([
                'errors' => [$exception->getMessage()]
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return $this->json($order, Response::HTTP_CREATED);
    }

    #[Route('/{id}', name: 'order_read', methods: ['GET'])]
    public function get(int $id): JsonResponse
    {
        $order = $this->orderService->get($id);
        if (!$order) {
            return $this->json(['error' => 'Order not found'], Response::HTTP_NOT_FOUND);
        }

        return $this->json($order);
    }

    private function getFormErrors($form): array
    {
        $errors = [];
        foreach ($form->all() as $child) {
            foreach ($child->getErrors(true) as $error) {
                $errors[$child->getName()][] = $error->getMessage();
            }
        }
        return $errors;
    }
}