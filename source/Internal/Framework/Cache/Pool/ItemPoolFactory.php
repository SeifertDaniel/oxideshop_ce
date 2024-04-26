<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\EshopCommunity\Internal\Framework\Cache\Pool;

use Psr\Cache\CacheItemPoolInterface;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

class ItemPoolFactory
{
    public static function create(string $namespace, string $directory): CacheItemPoolInterface
    {
        return new FilesystemAdapter(namespace: $namespace, directory: $directory);
    }
}