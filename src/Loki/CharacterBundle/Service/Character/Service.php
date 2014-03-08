<?php
/**
 * Created by PhpStorm.
 * User: marcus
 * Date: 21.02.14
 * Time: 17:31
 */

namespace Loki\CharacterBundle\Service\Character;
use Loki\CharacterBundle\Entity\CharacterToAttribute;
use Loki\CharacterBundle\Repository\CharacterRepository;
use Loki\CharacterBundle\Repository\CharacterToAttributeRepository;
use Loki\CharacterBundle\Service\Attribute\Service as AttService;

class Service {

    private $attributeRepo;
    private $characterRepo;
    private $characterToAttributeRepo;

    public function __construct( $attrRepo,  $repo,  $repo2)
    {
        $this->attributeRepo = $attrRepo;
        $this->characterRepo = $repo;
        $this->characterToAttributeRepo = $repo2;
    }

    public function foo()
    {
        return "bar";
    }

    public function addAttributesToCharacter($character)
    {
        $this->$characterToAttributeRepo;
        $attr = array();
        for($i = 1 ; $i<=8; $i++)
        {
            $attr[$i] = new CharacterToAttribute();
            $attr[$i]->setLevel(1);
            $attr[$i]->setCharacter($character);
        }
        $attr[1]->setAttribute($this->attributeRepo->getConstitution());
        $attr[2]->setAttribute($this->attributeRepo->getQuickness());
        $attr[3]->setAttribute($this->attributeRepo->getStrength());
        $attr[4]->setAttribute($this->attributeRepo->getCharisma());
        $attr[5]->setAttribute($this->attributeRepo->getIntelligence());
        $attr[6]->setAttribute($this->attributeRepo->getWillpower());
        $attr[7]->setAttribute($this->attributeRepo->getEssence());
        $attr[8]->setAttribute($this->attributeRepo->getMagic());
        //TODO Maybe add Transaktion here, via entitimanager->persist and entitimanager->flush
        for($i = 1 ; $i<=8; $i++)
        {

            $this->$characterToAttributeRepo->persist($attr[$i]);
        }
    }


} 