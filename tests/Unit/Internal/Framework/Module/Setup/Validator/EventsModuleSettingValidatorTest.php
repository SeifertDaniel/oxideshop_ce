<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\EshopCommunity\Tests\Unit\Internal\Framework\Module\Setup\Validator;

use OxidEsales\EshopCommunity\Internal\Transition\Adapter\ShopAdapter;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Configuration\DataObject\ModuleConfiguration;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Setup\Validator\EventsValidator;
use OxidEsales\EshopCommunity\Tests\Integration\Internal\Framework\Module\TestData\TestModule\ModuleEvents;
use PHPUnit\Framework\TestCase;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Configuration\DataObject\ModuleConfiguration\Event;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Setup\Exception\ModuleSettingNotValidException;

class EventsModuleSettingValidatorTest extends TestCase
{
    /**
     * @doesNotPerformAssertions
     */
    public function testValidate()
    {
        $validator = $this->createValidator();

        $moduleConfiguration = new ModuleConfiguration();
        $moduleConfiguration->addEvent(new Event('onActivate', ModuleEvents::class . '::onActivate'));
        $moduleConfiguration->addEvent(new Event('onDeactivate', ModuleEvents::class . '::onDeactivate'));

        $validator->validate($moduleConfiguration, 1);
    }

    public function testValidateThrowsExceptionIfEventsDefinedAreNotCallable()
    {
        $this->expectException(ModuleSettingNotValidException::class);
        $validator = $this->createValidator();

        $moduleConfiguration = new ModuleConfiguration();
        $moduleConfiguration->addEvent(new Event('onActivate', 'SomeNamespace\\class::noCallableMethod'));
        $moduleConfiguration->addEvent(new Event('onDeactivate', 'SomeNamespace\\class::noCallableMethod'));

        $this->expectException(ModuleSettingNotValidException::class);
        $validator->validate($moduleConfiguration, 1);
    }

    /**
     * @dataProvider invalidEventsProvider
     *
     * @param Event $invalidEvent
     *
     * @doesNotPerformAssertions
     *
     * @throws \OxidEsales\EshopCommunity\Internal\Framework\Module\Setup\Exception\ModuleSettingNotValidException
     */
    public function testValidateDoesNotValidateSyntax($invalidEvent)
    {
        $validator = $this->createValidator();

        $moduleConfiguration = new ModuleConfiguration();
        $moduleConfiguration->addEvent($invalidEvent);

        $validator->validate($moduleConfiguration, 1);
    }

    public function invalidEventsProvider(): array
    {
        return [
            [new Event('invalidEvent', 'noCallableMethod')],
            [new Event('', '')]
        ];
    }

    /**
     * @return EventsValidator
     */
    private function createValidator(): EventsValidator
    {
        return new EventsValidator(new ShopAdapter());
    }
}
