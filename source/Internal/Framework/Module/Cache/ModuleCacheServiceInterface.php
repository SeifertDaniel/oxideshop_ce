<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\EshopCommunity\Internal\Framework\Module\Cache;

interface ModuleCacheServiceInterface
{
    public function invalidate(string $key): void;

    public function put(string $key, array $data): void;

    public function get(string $key): array;

    public function exists(string $key): bool;
}
