<?php

namespace OxidEsales\EshopCommunity\Tests\Unit\Internal\Framework\Cache\Pool;

use OxidEsales\EshopCommunity\Internal\Framework\Cache\Pool\ShopPoolNameFactory;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;

#[Group('cache')]
class ShopPoolNameTest extends TestCase
{
    public function testGetPoolName(): void
    {
        $shopId = 1;
        $this->assertSame(
            'oxid_shop_pool_' . $shopId,
            ShopPoolNameFactory::get($shopId)
        );
    }

    public function testGetAllPoolName(): void
    {
        $this->assertSame(
            ['oxid_shop_pool_1', 'oxid_shop_pool_2', 'oxid_shop_pool_3', 'oxid_shop_pool_4', 'oxid_shop_pool_5'],
            ShopPoolNameFactory::getAll([1, 2, 3, 4, 5,])
        );
    }
}
