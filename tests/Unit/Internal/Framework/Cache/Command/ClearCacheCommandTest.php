<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\EshopCommunity\Tests\Unit\Internal\Framework\Cache\Command;

use OxidEsales\EshopCommunity\Internal\Framework\Cache\Command\ClearCacheCommand;
use OxidEsales\EshopCommunity\Internal\Framework\DIContainer\Service\ContainerCacheInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Cache\ModuleCacheServiceInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Templating\Cache\TemplateCacheService;
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

        $templateCacheServiceMock = $this->createMock(TemplateCacheService::class);
        $templateCacheServiceMock->expects($this->once())->method('invalidateTemplateCache');

        $containerCacheMock = $this->createMock(ContainerCacheInterface::class);
        $containerCacheMock->expects($this->once())->method('invalidate');

        $moduleCacheServiceMock = $this->createMock(ModuleCacheServiceInterface::class);
        $moduleCacheServiceMock->expects($this->once())->method('invalidateAll');

        $contextMock = $this->createMock(ContextInterface::class);
        $contextMock->expects($this->once())->method('getAllShopIds')->willReturn([1]);

        $command = new ClearCacheCommand(
            $shopAdapterMock,
            $templateCacheServiceMock,
            $containerCacheMock,
            $moduleCacheServiceMock,
            $contextMock
        );

        $command->run(
            $this->createMock(InputInterface::class),
            $this->createMock(OutputInterface::class),
        );
    }
}
