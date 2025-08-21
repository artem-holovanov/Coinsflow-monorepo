<?php
/**
 * Created by Artem Holovanov.
 * Date: 21.08.2025 18:07.
 */

declare(strict_types=1);

namespace App\MessageHandler;

use App\Service\ProductService;
use CommonBundle\ValueObject\ProductValue;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(fromTransport: 'async-product-replica', priority: 10)]
readonly class ProductNotificationHandler
{
    public function __construct(private ProductService $productService)
    {
    }

    /**
     * @param ProductValue $productValue
     * @return void
     */
    public function __invoke(ProductValue $productValue): void
    {
        // don't use try-catch here to let Retry strategy starts in case any Exception
        $this->productService->persistProduct($productValue);
    }
}
