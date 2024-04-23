<?php

namespace OxidEsales\EshopCommunity\Internal\Framework\Cache\Pool;

interface ShopPoolServiceInterface
{
    public function invalidate(int $shopId);
}