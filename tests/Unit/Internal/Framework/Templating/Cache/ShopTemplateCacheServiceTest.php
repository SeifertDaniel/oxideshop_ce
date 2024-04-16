<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\EshopCommunity\Tests\Unit\Internal\Framework\Templating\Cache;

use OxidEsales\EshopCommunity\Internal\Framework\Templating\Cache\ShopTemplateCacheService;
use OxidEsales\EshopCommunity\Internal\Framework\Templating\Cache\ShopTemplateCacheServiceInterface;
use OxidEsales\EshopCommunity\Internal\Transition\Utility\ContextInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Filesystem\Filesystem;

final class ShopTemplateCacheServiceTest extends TestCase
{
    private string $cacheDirectory = '/path/to/cache';
    private ShopTemplateCacheServiceInterface $shopTemplateCacheService;

    protected function setUp(): void
    {
        parent::setUp();

        $contextMock = $this->getMockBuilder(ContextInterface::class)->getMock();
        $fileSystemMock = $this->getMockBuilder(Filesystem::class)->getMock();

        $contextMock
            ->method('getCacheDirectory')
            ->willReturn($this->cacheDirectory);

        $this->shopTemplateCacheService = new ShopTemplateCacheService($contextMock, $fileSystemMock);
    }
    public function testGetCacheDirectory(): void
    {
        $shopId = 123;

        $shopCachePath = $this->shopTemplateCacheService->getCacheDirectory($shopId);

        $this->assertEquals($this->cacheDirectory . '/template_cache/shops/' . $shopId, $shopCachePath);
    }
}
