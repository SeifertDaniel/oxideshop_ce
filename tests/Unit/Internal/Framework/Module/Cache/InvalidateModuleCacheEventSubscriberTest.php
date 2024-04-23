<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\EshopCommunity\Tests\Unit\Internal\Framework\Module\Cache;

use OxidEsales\EshopCommunity\Internal\Framework\Cache\Pool\ShopPoolServiceInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Cache\InvalidateModuleCacheEventSubscriber;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Setup\Event\ModuleSetupEvent;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class InvalidateModuleCacheEventSubscriberTest extends TestCase
{
    public function testSubscriberCallsModuleCacheService(): void
    {
        $shopPoolService = $this->getMockBuilder(ShopPoolServiceInterface::class)->getMock();
        $shopPoolService
            ->expects($this->once())
            ->method('invalidate');

        $event = new class (1, 'testModuleId') extends ModuleSetupEvent {
        };

        $subscriber = new InvalidateModuleCacheEventSubscriber($shopPoolService);
        $subscriber->invalidateModuleCache($event);
    }
}
