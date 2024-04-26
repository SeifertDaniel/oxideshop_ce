<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\EshopCommunity\Internal\Framework\Cache\Pool;

use OxidEsales\EshopCommunity\Internal\Framework\Templating\Cache\ShopTemplateCacheServiceInterface;
use OxidEsales\EshopCommunity\Internal\Transition\Adapter\ShopAdapterInterface;
use Psr\Cache\CacheItemPoolInterface;

class ShopPoolFactory implements ShopPoolFactoryInterface
{
    public function __construct(
        private readonly ShopAdapterInterface $shopAdapter,
        private readonly ShopTemplateCacheServiceInterface $templateCacheService
    ) {
    }

    public function create(CacheItemPoolInterface $cacheItemPool): ShopPoolServiceInterface
    {
        return new ShopPoolService($cacheItemPool, $this->shopAdapter, $this->templateCacheService);
    }
}