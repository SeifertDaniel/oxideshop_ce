<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\EshopCommunity\Internal\Framework\Module\Cache;

use Psr\Cache\CacheItemPoolInterface;

class ModuleCache implements ModuleCacheServiceInterface
{
    public function __construct(private readonly CacheItemPoolInterface $cache)
    {
    }

    public function invalidate(string $key): void
    {
        $this->cache->deleteItem($key);
    }

    public function put(string $key, array $data): void
    {
        $cacheModulePathItem = $this->cache->getItem($key);
        $cacheModulePathItem->set($data);
        $this->cache->save($cacheModulePathItem);
    }

    /**
     * @throws CacheNotFoundException
     */
    public function get(string $key): array
    {
        $cacheModulePathItem = $this->cache->getItem($key);

        if (!$cacheModulePathItem->isHit()) {
            throw new CacheNotFoundException("Cache with key '$key' not found.");
        }

        return $cacheModulePathItem->get();
    }

    public function exists(string $key): bool
    {
        return $this->cache->getItem($key)->isHit();
    }
}
