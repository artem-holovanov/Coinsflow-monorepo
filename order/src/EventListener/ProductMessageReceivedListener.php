<?php
/**
 * Created by Artem Holovanov.
 * Date: 21.08.2025 20:48.
 */

declare(strict_types=1);

namespace App\EventListener;

use App\Repository\ProductRepository;
use CommonBundle\ValueObject\ProductValue;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\Messenger\Event\WorkerMessageReceivedEvent;
use Symfony\Component\Messenger\Stamp\RedeliveryStamp;

#[AsEventListener]
final readonly class ProductMessageReceivedListener
{
    public function __construct(private ProductRepository $productRepository)
    {
    }

    public function __invoke(WorkerMessageReceivedEvent $event): void
    {
        $request = $event->getEnvelope()->getMessage();

        if (!$request instanceof ProductValue) {
            return;
        }

        $isRequestHandled = $this->productRepository->count(['id' => $request->id()]) > 0;

        $redeliveryStampArray = $event->getEnvelope()->all(RedeliveryStamp::class);
        $isNotRetryStrategy = (0 === count($redeliveryStampArray));

        if ($isRequestHandled && $isNotRetryStrategy) {
            $event->shouldHandle(false);
        }
    }
}
