<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\EshopCommunity\Internal\Framework\Cache\Pool;

class ShopPoolNameFactory
{
    private static string $namePrefix = 'oxid_shop_pool_';

    public static function get(int $shopId): string
    {
        return static::$namePrefix . $shopId;
    }

    public static function getAll(array $shopIds): array
    {
        return array_map(
            static fn($id) => static::$namePrefix . $id,
            $shopIds
        );
    }
}