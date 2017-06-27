<?php

namespace Zorang\Bundle\AkeneoRulesComposer;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class ZorangAkeneoRulesComposer extends Bundle
{
    public function getParent()
    {
        return 'PimEnterpriseCatalogRuleBundle';

    }
}
