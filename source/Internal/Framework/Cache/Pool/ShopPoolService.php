<?php

namespace OxidEsales\EshopCommunity\Internal\Framework\Cache\Pool;

use OxidEsales\EshopCommunity\Internal\Framework\Templating\Cache\ShopTemplateCacheServiceInterface;
use OxidEsales\EshopCommunity\Internal\Transition\Adapter\ShopAdapterInterface;
use Psr\Cache\CacheItemPoolInterface;

class ShopPoolService implements ShopPoolServiceInterface
{
    public function __construct(
        private readonly CacheItemPoolInterface $cacheItemPool,
        private readonly ShopAdapterInterface $shopAdapter,
        private readonly ShopTemplateCacheServiceInterface $templateCacheService,
    ) {
    }

    public function invalidate(int $shopId): void
    {
        $this->templateCacheService->invalidateCache($shopId);
        $this->shopAdapter->invalidateModulesCache();
        $this->cacheItemPool->clear();
    }
}