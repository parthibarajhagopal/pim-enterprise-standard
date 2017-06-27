<?php

namespace Zorang\Bundle\AkeneoRulesComposer\Entity\Repository;

use Pim\Bundle\CatalogBundle\Doctrine\ORM\Repository\AttributeRepository as BaseAttributeRepository;

class AttributeRepository extends BaseAttributeRepository
{

    /**
     * {@inheritdoc}
     */
    public function findAttributeCodesTypes()
    {
        $codes = $this
            ->createQueryBuilder('a')
            ->select('a.code, a.attributeType')
            ->getQuery()
            ->getArrayResult();

        return array_map(
            function ($data) {
                return $data['code'] . '/' . substr($data['attributeType'], 12);
            },
            $codes
        );
    }
    public function findAttributeLocalScope()
    {
        $codes = $this
            ->createQueryBuilder('a')
            ->select('a.code, a.attributeType,CASE WHEN a.localizable = 1  then 1 else 0 end as localizable,CASE  WHEN a.scopable = 1  then 1 else 0 end as scopable' )
            ->getQuery()
            ->getArrayResult();

        return array_map(
            function ($data) {
                return $data['code'] . '/' . substr($data['attributeType'], 12)."/locale:".$data['localizable']."/scope:".$data['scopable'];
            },
            $codes
        );
    }

    public function findAttributeCodes()
    {
        $codes = $this
            ->createQueryBuilder('a')
            ->select('a.code, a.attributeType')
            ->orderBy('a.code')
            ->getQuery()
            ->getArrayResult();

        return array_map(
            function ($data) {
                return $data['code']. '/' . substr($data['attributeType'],12);
            },
            $codes
        );
    }

    // For currency or price attribute
    public function findAttributeTypeByCode($code)
    {
        $codes = $this
            ->createQueryBuilder('a')
            ->select('a.attributeType, CASE  WHEN a.localizable = 1 AND a.scopable = 1 then 1 else CASE WHEN a.localizable = 1 AND a.scopable = 0 THEN 2 ELSE CASE WHEN a.localizable = 0 AND a.scopable = 1 THEN 3 ELSE 0 end end end as status')
            ->where('a.code = :code')
            ->setParameter(':code', $code)
            ->getQuery()
            ->getArrayResult();
        return $codes;
    }

    //for getting attribute code type value for isscopable and islocalizable
    public function findScopeLocaleAttributeCodesTypes()
    {
        $codes = $this
            ->createQueryBuilder('a')
            ->select('a.code, a.attributeType, CASE  WHEN a.localizable = 1 AND a.scopable = 1 then 1 else CASE WHEN a.localizable = 1 AND a.scopable = 0 THEN 2 ELSE CASE WHEN a.localizable = 0 AND a.scopable = 1 THEN 3 ELSE 0 end end end as status')
            ->getQuery()
            ->getArrayResult();

        return array_map(
            function ($data) {
                return $data['code'] . '/' . substr($data['attributeType'], 12) . '/' .$data['status'];
            },
            $codes
        );
    }

    public function findScopeLocalActionAttributeCodes()
    {
        $codes = $this
            ->createQueryBuilder('a')
            ->select('a.code, a.attributeType,CASE  WHEN a.localizable = 1 AND a.scopable = 1 then 1 else CASE WHEN a.localizable = 1 AND a.scopable = 0 THEN 2 ELSE CASE WHEN a.localizable = 0 AND a.scopable = 1 THEN 3 ELSE 0 end end end as status')
            ->orderBy('a.code')
            ->getQuery()
            ->getArrayResult();

        return array_map(
            function ($data) {
                return $data['code']. '/' . substr($data['attributeType'],12).'/'. $data['status'];
            },
            $codes
        );
    }
}
