<?php

namespace App\Listeners;

use App\Services\ProductService\V1\Repository\Client\FlatProduct\FlatProductServiceRepository;
use App\Services\ProductService\V1\Repository\Admin\OrderedProduct\OrderedProductServiceRepository;
use Celysium\MessageBroker\Events\IncomingMessageEvent;

class IncomingMessageListener
{
    public function __construct(private readonly FlatProductServiceRepository $flatProductServiceRepository, private readonly OrderedProductServiceRepository $orderedProductServiceRepository)
    {
    }

    public function handle(IncomingMessageEvent $event): void
    {
        match ($event->event) {
            'inventoriesCreate',
            'inventoriesUpdated' => $this->flatProductServiceRepository->syncInventory($event->data),
            'orderSuccess' => $this->orderedProductServiceRepository->orderedProducts($event->data),
            default => null,
        };
    }
}
