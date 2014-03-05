<?php
/**
 * Created by PhpStorm.
 * User: marcus
 * Date: 11.02.14
 * Time: 21:26
 */

namespace Loki\CharacterBundle\Repository;


use Doctrine\ORM\EntityRepository;

class SkillRepository extends MyBaseRepository{



    /**
     * @param string $orderCrit
     * @param string $orderType
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function createQueryForFindAll(
        $orderCrit = 'id',
        $orderType = 'ASC'
    ) {
        $qb = $this->createQueryBuilder('skill')
            ->select('skill');
        $qb->orderBy('skill.' . $orderCrit, $orderType);

        return $qb;
    }
} 