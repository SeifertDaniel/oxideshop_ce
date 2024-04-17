<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\EshopCommunity\Tests\Integration\Internal\Framework\Env;

use OxidEsales\EshopCommunity\Internal\Framework\Configuration\BootstrapConfigurationFactory;
use OxidEsales\EshopCommunity\Internal\Framework\Env\DotenvLoader;
use OxidEsales\EshopCommunity\Tests\ContainerTrait;
use OxidEsales\EshopCommunity\Tests\EnvTrait;
use OxidEsales\EshopCommunity\Tests\RequestTrait;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Path;

final class EnvLoaderTest extends TestCase
{
    use RequestTrait;
    use ContainerTrait;
    use EnvTrait;

    private string $dotEnvFixture = '';
    private string $fixtures = __DIR__ . '/Fixtures';
    private string $appEnvKey = 'OXID_ENV';
    private string $serializedEnvKey = 'SERIALIZED_VALUE_KEY';
    private string $serializedParameterKey = 'serialized_value_key';


    public function setUp(): void
    {
        parent::setUp();
        $this->backupRequestData();
        $this->dotEnvFixture = Path::join($this->fixtures, '.env');
    }

    public function tearDown(): void
    {
        (new Filesystem())->remove($this->dotEnvFixture);
        $this->restoreRequestData();
        parent::tearDown();
    }

    public function testApplicationEnvironmentIsDefined(): void
    {
        (new BootstrapConfigurationFactory())->create();

        $currentEnvironment = getenv($this->appEnvKey);

        $this->assertNotEmpty($currentEnvironment);
    }

    public function testApplicationEnvironmentCanBeRedefined(): void
    {
        $someValue = uniqid('some-value', true);
        $this->loadEnvFixture($this->fixtures, ["$this->appEnvKey=$someValue"]);

        $currentEnvironment = getenv($this->appEnvKey);

        $this->assertEquals($someValue, $currentEnvironment);
    }

    public function testJsonDSNsWithSpecialCharactersWillBeParsedAsArray(): void
    {
        $somePassword = '"\[(üÄ\\" *123,.;)::""';
        $dsnString = "mysql://username:$somePassword@123.255.255.255:3306/db-name?charset=utf8&driverOptions[1002]=\"SET @@SESSION.sql_mode=\"\"\"";
        $serializedValue = json_encode(
            [$dsnString, $dsnString, $dsnString],
            JSON_THROW_ON_ERROR
        );
        $this->loadEnvFixture($this->fixtures, ["$this->serializedEnvKey='$serializedValue'"]);
        $this->createContainer();
        $this->loadYamlFixture($this->fixtures);
        $this->compileContainer();

        $containerParameter = $this->getParameter($this->serializedParameterKey);

        $this->assertEquals($dsnString, $containerParameter[2]);
    }

    public function testCanPutEnvironmentVariable(): void
    {
        $someKey = uniqid('some-key', true);
        $someValue = uniqid('some-value', true);

        $dotEnvLoader = new DotenvLoader($this->fixtures);
        $dotEnvLoader->putEnvironmentVariable($someKey, $someValue);

        $this->assertEquals($someValue, getenv($someKey));
    }
}
