<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\EshopCommunity\Tests\Integration\Internal\Framework\Cache;

use OxidEsales\EshopCommunity\Internal\Framework\Cache\Pool\ShopPoolServiceInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Cache\ModuleCacheServiceInterface;
use OxidEsales\EshopCommunity\Tests\ContainerTrait;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;

#[Group('cache')]
final class ShopPoolServiceTest extends TestCase
{
    use ContainerTrait;

    public function testInvalidateShopRelatedModuleCache(): void
    {
        $moduleCache = $this->getModuleCacheService();
        $moduleCache->put('test', ['something']);

        $shopPool = $this->getShopPoolService();
        $shopPool->invalidate(1);

        $this->assertFalse(
            $moduleCache->exists('test')
        );
    }

    private function getShopPoolService(): ShopPoolServiceInterface
    {
        return $this->get(ShopPoolServiceInterface::class);
    }

    private function getModuleCacheService(): ModuleCacheServiceInterface
    {
        return $this->get(ModuleCacheServiceInterface::class);
    }
}
