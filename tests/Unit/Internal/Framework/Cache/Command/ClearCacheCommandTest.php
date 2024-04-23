<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\EshopCommunity\Tests\Unit\Internal\Framework\Cache\Command;

use OxidEsales\EshopCommunity\Internal\Framework\Cache\Command\ClearCacheCommand;
use OxidEsales\EshopCommunity\Internal\Framework\Cache\Pool\ShopPoolServiceInterface;
use OxidEsales\EshopCommunity\Internal\Framework\DIContainer\Service\ContainerCacheInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Templating\Cache\ShopTemplateCacheServiceInterface;
use OxidEsales\EshopCommunity\Internal\Transition\Adapter\ShopAdapterInterface;
use OxidEsales\EshopCommunity\Internal\Transition\Utility\ContextInterface;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[Group('cache')]
class ClearCacheCommandTest extends TestCase
{
    public function testClearCacheTriggersRegularAndTemplatesCleaners(): void
    {
        $shopAdapterMock = $this->createMock(ShopAdapterInterface::class);
        $shopAdapterMock->expects($this->once())->method('invalidateModulesCache');

        $shopTemplateCacheServiceMock = $this->createMock(ShopTemplateCacheServiceInterface::class);
        $shopTemplateCacheServiceMock->expects($this->once())->method('invalidateAllShopsCache');

        $containerCacheMock = $this->createMock(ContainerCacheInterface::class);
        $containerCacheMock->expects($this->once())->method('invalidate');

        $shopPoolServiceMock = $this->createMock(ShopPoolServiceInterface::class);
        $shopPoolServiceMock->expects($this->once())->method('invalidate');

        $contextMock = $this->createMock(ContextInterface::class);
        $contextMock->expects($this->once())->method('getAllShopIds')->willReturn([1]);

        $command = new ClearCacheCommand(
            $shopAdapterMock,
            $shopTemplateCacheServiceMock,
            $containerCacheMock,
            $shopPoolServiceMock,
            $contextMock
        );

        $command->run(
            $this->createMock(InputInterface::class),
            $this->createMock(OutputInterface::class),
        );
    }
}
