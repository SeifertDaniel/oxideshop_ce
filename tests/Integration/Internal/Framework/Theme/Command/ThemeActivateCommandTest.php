<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\EshopCommunity\Tests\Integration\Internal\Framework\Theme\Command;

use OxidEsales\Eshop\Core\Registry;
use OxidEsales\EshopCommunity\Internal\Container\ContainerFactory;
use OxidEsales\EshopCommunity\Internal\Framework\Theme\Command\ThemeActivateCommand;
use OxidEsales\EshopCommunity\Tests\ContainerTrait;
use OxidEsales\EshopCommunity\Tests\Integration\IntegrationTestCase;
use OxidEsales\EshopCommunity\Tests\TestContainerFactory;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Tester\CommandTester;

final class ThemeActivateCommandTest extends IntegrationTestCase
{
    use ContainerTrait;

    private string $fixtureDirectory = __DIR__ . '/Fixtures';

    private string $themeId = 'testTheme';
    private array $originalConfig;

    private ContainerInterface $originalContainer;

    public function setUp(): void
    {
        parent::setUp();
        $this->saveOriginalContainer();
        $this->setShopFixtures();
    }

    public function tearDown(): void
    {
        $this->restoreOriginalConfig();
        parent::tearDown();
    }

    public function testThemeActivationOnSuccess(): void
    {
        $arguments = ['theme-id' => $this->themeId];

        $themeActivateCommand = $this->getCommandObject();
        $commandTester = new CommandTester($themeActivateCommand);

        $commandTester->execute($arguments);
        $this->assertSame($this->themeId, $this->getActiveTheme());
    }

    public function testThemeAlreadyActivated(): void
    {
        $arguments = ['theme-id' => $this->themeId];

        $themeActivateCommand = $this->getCommandObject();
        $commandTester = new CommandTester($themeActivateCommand);
        $commandTester->execute($arguments);
        $commandTester->execute($arguments); //running twice is important

        $this->assertStringContainsString(
            sprintf('Theme - "%s" is already active.', $this->themeId),
            $commandTester->getDisplay()
        );
    }

    public function testNonExistingThemeActivation(): void
    {
        $nonExistingThemeId = 'some-theme-id';
        $arguments = ['theme-id' => $nonExistingThemeId];

        $themeActivateCommand = $this->getCommandObject();
        $commandTester = new CommandTester($themeActivateCommand);
        $commandTester->execute($arguments);

        $this->assertStringContainsString(
            sprintf('Theme - "%s" not found.', $nonExistingThemeId),
            $commandTester->getDisplay()
        );

        $this->assertSame('absolute-dummy-value', $this->getActiveTheme());
    }

    private function getCommandObject(): ThemeActivateCommand
    {
        return $this->get(ThemeActivateCommand::class);
    }

    private function getActiveTheme(): string
    {
        return Registry::getConfig()->getConfigParam('sTheme');
    }

    private function setShopFixtures(): void
    {
        Registry::getConfig()->reinitialize();
        Registry::getConfig()->setConfigParam('sTheme', 'absolute-dummy-value');

        $this->container = (new TestContainerFactory())->create();
        $this->container->setParameter('oxid_shop_directory', "$this->fixtureDirectory/shop/source/");
        $this->container->compile();

        ContainerFactory::getInstance()->setContainer($this->container);
    }

    private function saveOriginalContainer(): void
    {
        $this->originalConfig = [
            'sTheme' => Registry::getConfig()->getConfigParam('sTheme')
        ];

        $this->originalContainer = ContainerFactory::getInstance()->getContainer();
    }

    private function restoreOriginalConfig(): void
    {
        Registry::getConfig()->reinitialize();
        Registry::getConfig()->setConfigParam('sTheme', $this->originalConfig['sTheme']);

        ContainerFactory::getInstance()->setContainer($this->originalContainer);
    }
}
