<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Internal\Framework\Database;

use Doctrine\DBAL\Driver\Connection;

<<<<<<<< HEAD:source/Internal/Framework/Database/ConnectionFactoryInterface.php
interface ConnectionFactoryInterface
========
/**
 * @deprecated will be removed in next major
 */
interface ConnectionProviderInterface
>>>>>>>> 88915c445 (OXDEV-7248 Switch DB configs [WIP]):source/Internal/Framework/Database/ConnectionProviderInterface.php
{
    public function create(): Connection;
}
