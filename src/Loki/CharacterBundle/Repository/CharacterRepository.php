<?php
/**
 * Created by PhpStorm.
 * User: marcus
 * Date: 11.02.14
 * Time: 21:22
 */

namespace Loki\CharacterBundle\Repository;


use Doctrine\ORM\EntityRepository;

class CharacterRepository extends AbstractBaseRepository{


    /**
     * @param string $orderCrit
     * @param string $orderType
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function createQueryForFindAll(
        $orderCrit = 'id',
        $orderType = 'ASC'
    ) {
        $qb = $this->createQueryBuilder('character')
            ->select('character');
        $qb->orderBy('character.' . $orderCrit, $orderType);

        return $qb;
    }

} 