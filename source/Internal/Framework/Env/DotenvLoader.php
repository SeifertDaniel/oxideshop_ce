<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\EshopCommunity\Internal\Framework\Env;

use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\Filesystem\Path;

class DotenvLoader implements DotenvLoaderInterface
{
    private string $envKey = 'OXID_ENV';
    private string $debugKey = 'OXID_DEBUG';
    private string $envFile = '.env';
    /**
     * @var \Symfony\Component\Dotenv\Dotenv
     */
    private Dotenv $dotEnv;

    public function __construct(private readonly string $pathToEnvFiles)
    {
        $this->dotEnv = new Dotenv($this->envKey, $this->debugKey);
        $this->dotEnv->usePutenv();
    }

    public function loadEnvironmentVariables(): void
    {
        $this->dotEnv->loadEnv(Path::join($this->pathToEnvFiles, $this->envFile));
    }

    public function putEnvironmentVariable(string $name, $value): void
    {
        $this->dotEnv->populate([$name => $value]);
    }
}
