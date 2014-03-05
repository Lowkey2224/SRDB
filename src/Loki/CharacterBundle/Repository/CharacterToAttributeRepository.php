<?php
/**
 * Created by PhpStorm.
 * User: marcus
 * Date: 11.02.14
 * Time: 21:23
 */

namespace Loki\CharacterBundle\Repository;


use Doctrine\ORM\EntityRepository;
use Loki\CharacterBundle\Entity\Attribute;
use Loki\CharacterBundle\Entity\Character;

class CharacterToAttributeRepository extends MyBaseRepository{

    public function findByCharacter($character, array $orderBy = null, $limit = null, $offset = null)
    {
        if($character instanceof Character)
        {
            return parent::findBy(array('character' => $character), $orderBy, $limit, $offset );
        }else{
            return array();
        }
    }

    public function findByOneCharacterAndAttribute($character, $attribute, array $orderBy = null, $limit = null, $offset = null)
    {
        if($character instanceof Character && $attribute instanceof Attribute)
        {
            return parent::findOneBy(array('character' => $character, 'attribute' => $attribute), $orderBy, $limit, $offset );
        }else{
            return null;
        }
    }



} 