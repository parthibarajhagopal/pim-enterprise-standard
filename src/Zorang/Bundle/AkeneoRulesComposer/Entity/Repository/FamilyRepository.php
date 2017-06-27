<?php

namespace Zorang\Bundle\AkeneoRulesComposer\Entity\Repository;

use Pim\Bundle\CatalogBundle\Doctrine\ORM\Repository\FamilyRepository as BaseFamilyRepository;

class FamilyRepository extends BaseFamilyRepository
{

    /**
     * {@inheritdoc}
     */
    public function findFamilyCodes()
    {
        $codes = $this
            ->createQueryBuilder('f')
            ->select('f.code')
            ->getQuery()
            ->getArrayResult();

        return array_map(
            function ($data) {
                return $data['code'];
            },
            $codes
        );
    }
}
