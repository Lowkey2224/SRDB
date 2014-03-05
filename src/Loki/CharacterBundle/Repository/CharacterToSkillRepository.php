<?php
/**
 * Created by PhpStorm.
 * User: marcus
 * Date: 11.02.14
 * Time: 21:23
 */

namespace Loki\CharacterBundle\Repository;


use Doctrine\ORM\EntityRepository;
use Loki\CharacterBundle\Entity\Character;

class CharacterToSkillRepository extends MyBaseRepository{

    public function findByCharacter(Character $character, array $orderBy = null, $limit = null, $offset = null)
    {
        return parent::findBy(array('character' => $character), $orderBy, $limit, $offset );
    }
}

