<?php
/**
 * Created by PhpStorm.
 * User: marcus
 * Date: 11.02.14
 * Time: 21:21
 */

namespace Loki\CharacterBundle\Repository;


use Doctrine\ORM\EntityRepository;
use Loki\CharacterBundle\Entity\Attribute;

class AttributeRepository extends AbstractBaseRepository{



    /**
     * @param string $orderCrit
     * @param string $orderType
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function createQueryForFindAll(
        $orderCrit = 'id',
        $orderType = 'ASC'
    ) {
        $qb = $this->createQueryBuilder('att')
            ->select('att');
        $qb->orderBy('att.' . $orderCrit, $orderType);

        return $qb;
    }

    public function getConstitution()
    {
        $entry = $this->findOneByName("Konstitution");
        if(is_null($entry))
        {
            $entry = new Attribute();
            $entry->setName("Konstitution");
            $this->persist($entry);
        }
        return $entry;
    }
    
    public function getQuickness()
    {
        $entry = $this->findOneByName("Schnelligkeit");
        if(is_null($entry))
        {
            $entry = new Attribute();
            $entry->setName("Schnelligkeit");
            $this->persist($entry);
        }
        return $entry;
    }

    public function getStrength()
    {
        $entry = $this->findOneByName("Stärke");
        if(is_null($entry))
        {
            $entry = new Attribute();
            $entry->setName("Stärke");
            $this->persist($entry);
        }
        return $entry;
    }

    public function getCharisma()
    {
        $entry = $this->findOneByName("Charisma");
        if(is_null($entry))
        {
            $entry = new Attribute();
            $entry->setName("Charisma");
            $this->persist($entry);
        }
        return $entry;
    }

    public function getIntelligence()
    {
        $entry = $this->findOneByName("Intelligenz");
        if(is_null($entry))
        {
            $entry = new Attribute();
            $entry->setName("Intelligenz");
            $this->persist($entry);
        }
        return $entry;
    }

    public function getWillpower()
    {
        $entry = $this->findOneByName("Willenskraft");
        if(is_null($entry))
        {
            $entry = new Attribute();
            $entry->setName("Willenskraft");
            $this->persist($entry);
        }
        return $entry;
    }

    public function getEssence()
    {
        $entry = $this->findOneByName("Essenz");
        if(is_null($entry))
        {
            $entry = new Attribute();
            $entry->setName("Essenz");
            $this->persist($entry);
        }
        return $entry;
    }

    public function getMagic()
    {
        $entry = $this->findOneByName("Magie");
        if(is_null($entry))
        {
            $entry = new Attribute();
            $entry->setName("Magie");
            $this->persist($entry);
        }
        return $entry;
    }

    public function getCombatpool()
    {
        $entry = $this->findOneByName("Kampfpool");
        if(is_null($entry))
        {
            $entry = new Attribute();
            $entry->setName("Kampfpool");
            $this->persist($entry);
        }
        return $entry;
    }

    public function getAstralcombatpool()
    {
        $entry = $this->findOneByName("Astralkampfpool");
        if(is_null($entry))
        {
            $entry = new Attribute();
            $entry->setName("Astralkampfpool");
            $this->persist($entry);
        }
        return $entry;
    }

    public function getTaskpool()
    {
        $entry = $this->findOneByName("Taskpool");
        if(is_null($entry))
        {
            $entry = new Attribute();
            $entry->setName("Taskpool");
            $this->persist($entry);
        }
        return $entry;
    }

    public function getSorcerypool()
    {
        $entry = $this->findOneByName("Hexereipool");
        if(is_null($entry))
        {
            $entry = new Attribute();
            $entry->setName("Hexereipool");
            $this->persist($entry);
        }
        return $entry;
    }

    public function getHackingpool()
    {
        $entry = $this->findOneByName("Hackingpool");
        if(is_null($entry))
        {
            $entry = new Attribute();
            $entry->setName("Hackingpool");
            $this->persist($entry);
        }
        return $entry;
    }

    public function getControlpool()
    {
        $entry = $this->findOneByName("Steuerpool");
        if(is_null($entry))
        {
            $entry = new Attribute();
            $entry->setName("Steuerpool");
            $this->persist($entry);
        }
        return $entry;
    }


} 