<?php

/*
 * This file is part of the Akeneo PIM Enterprise Edition.
 *
 * (c) 2014 Akeneo SAS (http://www.akeneo.com)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zorang\Bundle\AkeneoRulesComposer\Entity\Repository;

use Akeneo\Bundle\RuleEngineBundle\Doctrine\ORM\Repository\RuleDefinitionRepository as BaseRuleDefinitionRepository;


class RuleDefinitionRepository extends BaseRuleDefinitionRepository
{

    public function findByIdNew($id)
    {
//        var_dump($id);


        $qb = $this->createQueryBuilder('r');
        $qb
            ->select('r.code')
            ->where('r.id = :id')
            ->setParameter(':id', $id);

        $codes = $qb->getQuery()
            ->getArrayResult();

        return array_map(
            function ($data) {
                return $data['code'];
            },
            $codes
        );
    }
    public function findPriority($id)
    {
//        var_dump($id);
        $qb = $this->createQueryBuilder('r');
        $qb
            ->select('r.priority')
            ->where('r.id = :id')
            ->setParameter(':id', $id);

        $priority = $qb->getQuery()
            ->getArrayResult();

        return array_map(
            function ($data) {
                return $data['priority'];
            },
            $priority
        );
    }

    public function getConditionsById($id)
    {

        $qb = $this->createQueryBuilder('r');
        $qb
            ->select('r.content')
            ->where('r.id = :id')
            ->setParameter(':id', $id);

        $content = $qb->getQuery()
            ->getArrayResult();

        $contentArr = array_map(
            function ($data) {
                return $data['content'];
            },
            $content
        );

        return array_map(
            function ($data) {
                return $data['conditions'];
            },
            $contentArr
        );
    }

    public function getActionsById($id)
    {
        $qb = $this->createQueryBuilder('r');
        $qb
            ->select('r.content')
            ->where('r.id = :id')
            ->setParameter(':id', $id);

        $content = $qb->getQuery()
            ->getArrayResult();

        $contentArr = array_map(
            function ($data) {
                return $data['content'];
            },
            $content
        );

        return array_map(
            function ($data) {
                return $data['actions'];
            },
            $contentArr
        );
    }/*
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
);*/

/*
 * @findRuleFamilyCodes() will fetch data from family table
 */
    public function findRuleFamilyCodes()
    {
        $em=$this->getEntityManager();
        $connection = $em->getConnection();
        $statement = $connection->prepare(
            'SELECT code FROM pim_catalog_family ORDER BY id'
        );

        $statement->execute();
        $result = $statement->fetchAll();
        return array_map(
            function ($data) {
                return $data['code'];
            },
            $result);
    }

    /***  ### Rule UI Currency code Functionality Changes start ### */

    public function findActivatedCurrencyCode()
    {
        $em=$this->getEntityManager();
        $connection = $em->getConnection();
        $statement = $connection->prepare(
            'select code from pim_catalog_currency where is_activated = 1'
        );

        $statement->execute();
        $result = $statement->fetchAll();
        return array_map(
            function ($data) {
                return $data['code'];
            },
            $result);

    }

    /***  ### Rule UI Currency code Functionality Changes End ### */
// Rule UI PIM_locale_code from DB
    public function findActivatedPimLocaleCode()
    {
        $em=$this->getEntityManager();
        $connection = $em->getConnection();
        $statement = $connection->prepare(
            'select code from pim_catalog_locale where is_activated = 1'
        );

        $statement->execute();
        $result = $statement->fetchAll();
        return array_map(
            function ($data) {
                return $data['code'];
            },
            $result);

    }

// Rule UI PIM_scope_code from DB
    public function findActivatedPimScopeCode()
    {
        $em=$this->getEntityManager();
        $connection = $em->getConnection();
        $statement = $connection->prepare(
            'select code from pim_catalog_channel'
        );

        $statement->execute();
        $result = $statement->fetchAll();
        return array_map(
            function ($data) {
                return $data['code'];
            },
            $result);

    }

/*
    // Rule scope count from DB
    public function findPimScopeCount()
    {
        $em=$this->getEntityManager();
        $connection = $em->getConnection();
        $statement = $connection->prepare(
            'select count(code) as count from pim_catalog_channel'
        );

        $statement->execute();
        $result = $statement->fetchAll();
        return $result;

    }*/

    // Rule PIM_locale_count from DB
    public function findActivatedPimLocaleScopeCount()
    {
        $em=$this->getEntityManager();
        $connection = $em->getConnection();
        $statement = $connection->prepare(
            'SELECT (SELECT COUNT(*) FROM pim_catalog_channel) as channelCount, (SELECT COUNT(*) FROM pim_catalog_locale WHERE is_activated = 1) as localeCount
'
        );

        $statement->execute();
        $result = $statement->fetchAll();
        return $result;

    }
//SELECT (SELECT COUNT(*) FROM pim_catalog_channel) as channelCount, (SELECT COUNT(*) FROM pim_catalog_locale WHERE is_activated = 1) as localeCount
}
