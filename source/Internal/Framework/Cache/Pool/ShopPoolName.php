<?php

namespace OxidEsales\EshopCommunity\Internal\Framework\Cache\Pool;

class ShopPoolName
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