<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\EshopCommunity\Internal\Framework\Module\Cache;

use OxidEsales\EshopCommunity\Internal\Framework\Templating\Cache\ShopTemplateCacheServiceInterface;
use OxidEsales\EshopCommunity\Internal\Transition\Adapter\ShopAdapterInterface;
use Symfony\Contracts\Cache\CacheInterface;

class ModuleCache implements ModuleCacheServiceInterface
{
    public function __construct(
        private readonly ShopAdapterInterface $shopAdapter,
        private readonly ShopTemplateCacheServiceInterface $templateCacheService,
        private readonly CacheInterface $cache
    ) {
    }

    public function invalidate(string $moduleId, int $shopId): void
    {
        $this->templateCacheService->invalidateCache($shopId);
        $this->shopAdapter->invalidateModuleCache($moduleId);
        $this->cache->clear();
    }

    public function invalidateAll(): void
    {
        $this->templateCacheService->invalidateAllShopsCache();
        $this->shopAdapter->invalidateModulesCache();

        $this->cache->clear();
    }

    public function put(string $key, int $shopId, array $data): void
    {
        $cacheModulePathItem = $this->cache->getItem($key);
        $cacheModulePathItem->set($data);
        $this->cache->save($cacheModulePathItem);
    }

    /**
     * @throws CacheNotFoundException
     */
    public function get(string $key, int $shopId): array
    {
        $cacheModulePathItem = $this->cache->getItem($key);

        if (!$cacheModulePathItem->isHit()) {
            throw new CacheNotFoundException(
                "Cache with key '$key' for the shop with id $shopId not found."
            );
        }

        return $cacheModulePathItem->get();
    }

    public function exists(string $key, int $shopId): bool
    {
        return $this->cache->getItem($key)->isHit();
    }
}
