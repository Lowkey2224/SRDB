<?php
/**
 * Created by Marcus "Loki" Jenz 
 * Date: 09.03.14
 * Time: 19:08
 */

namespace Loki\CharacterBundle\Repository;


use Loki\CharacterBundle\Entity\CharacterToSkill;

class SpecializationRepository extends AbstractBaseRepository{

    /**
     * @param CharacterToSkill $skill
     * @param string $orderCrit
     * @param string $orderType
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function createQueryForFindBySkill($skillId,
        $orderCrit = 'id',
        $orderType = 'ASC'
    ) {
        $qb = $this->createQueryBuilder('spec')
            ->select('spec')
            ->where('spec.skill = ?1');
        $qb->setParameter(1, $skillId);
        $qb->orderBy('spec.' . $orderCrit, $orderType);

        return $qb;
    }
} 