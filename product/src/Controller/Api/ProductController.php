<?php
/**
 * Created by Artem Holovanov.
 * Date: 20.08.2025 19:03.
 */

declare(strict_types=1);

namespace App\Controller\Api;

use App\Entity\Product;
use App\Form\ProductType;
use App\Service\ProductService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Uid\Uuid;

#[Route('/api/products')]
class ProductController extends AbstractController
{
    public function __construct(
        private readonly ProductService $productService,
    ) {}

    #[Route('', name: 'product_index', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $products = $this->productService->getAll();
        return $this->json(['data' => $products], Response::HTTP_OK);
    }

    #[Route('', name: 'product_create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $data = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);
        $form->submit($data);

        if (!$form->isValid()) {
            return $this->json([
                'errors' => $this->getFormErrors($form)
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $this->productService->create($product);

        return $this->json($product, Response::HTTP_CREATED);
    }

    #[Route('/{id}', name: 'product_read', methods: ['GET'])]
    public function get(Uuid $id): JsonResponse
    {
        $product = $this->productService->get($id);
        if (!$product) {
            return $this->json(['error' => 'Product not found'], Response::HTTP_NOT_FOUND);
        }

        return $this->json($product);
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