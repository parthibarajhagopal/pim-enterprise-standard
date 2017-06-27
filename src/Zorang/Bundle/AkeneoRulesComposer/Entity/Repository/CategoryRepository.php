<?php

namespace Zorang\Bundle\AkeneoRulesComposer\Entity\Repository;

use Pim\Bundle\EnrichBundle\Doctrine\ORM\Repository\CategoryRepository as BaseCategoryRepository;
use Pim\Component\Catalog\AttributeTypes;

class CategoryRepository extends BaseCategoryRepository
{

    public function findCategoryId($code)
    {
        $qb = $this->createQueryBuilder('a');
        $qb
            ->select('a.id')
            ->where('a.code = :code')
            ->setParameter(':code', $code);

        $codes = $qb->getQuery()
            ->getArrayResult();

        return array_map(
            function ($data) {
                return $data['id'];
            },
            $codes
        );
    }

    public function findVendorsCategoryId()
    {
        $qb = $this->createQueryBuilder('a');
        $qb
            ->select('a.id')
            ->where('a.code = :vendors')
            ->setParameter(':vendors', 'vendors');

        $codes = $qb->getQuery()
            ->getArrayResult();

        return array_map(
            function ($data) {
                return $data['id'];
            },
            $codes
        );
    }

    public function getAllChildrenCodes($parentId)
    {
        $qb = $this->createQueryBuilder('a');
        $qb
            ->select('a.code')
            ->where('a.parent = :parentId')
            ->setParameter(':parentId', $parentId);

        $codes = $qb->getQuery()
            ->getArrayResult();

        return array_map(
            function ($data) {
                return $data['code'];
            },
            $codes
        );
    }

    public function findTranslatedLabelsChildren($parentId)
    {
        $query = $this->childrenQueryBuilder(null, true, 'created', 'DESC')
            ->select('node.code')
            ->addSelect('COALESCE(NULLIF(t.label, \'\'), CONCAT(\'[\', node.code, \']\')) as label')
            ->where('node.parent = :parentId')
            ->leftJoin('node.translations', 't', 'WITH', 't.locale = :locale')
            ->setParameter('locale', 'en_CA')
            ->setParameter(':parentId', $parentId)
            ->orderBy('t.label')
            ->getQuery();


        $choices = [];
        foreach ($query->getArrayResult() as $code) {
            $choices[$code['code']] = $code['label'];
        }

        return $choices;
    }



}
