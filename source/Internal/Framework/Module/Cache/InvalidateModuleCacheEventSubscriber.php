<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\EshopCommunity\Internal\Framework\Module\Cache;

use OxidEsales\EshopCommunity\Internal\Framework\Cache\Pool\ShopPoolServiceInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Configuration\Event\ModuleConfigurationChangedEvent;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Setup\Event\FinalizingModuleActivationEvent;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Setup\Event\FinalizingModuleDeactivationEvent;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Setup\Event\ModuleSetupEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class InvalidateModuleCacheEventSubscriber implements EventSubscriberInterface
{
    public function __construct(private readonly ShopPoolServiceInterface $shopPoolService)
    {
    }

    public function invalidateModuleCache(ModuleSetupEvent|ModuleConfigurationChangedEvent $event): void
    {
        $this->shopPoolService->invalidate($event->getShopId());
    }

    public static function getSubscribedEvents(): array
    {
        return [
            FinalizingModuleActivationEvent::class   => 'invalidateModuleCache',
            FinalizingModuleDeactivationEvent::class => 'invalidateModuleCache',
            ModuleConfigurationChangedEvent::class => 'invalidateModuleCache',
        ];
    }
}
