<?php
/**
 * Created by PhpStorm.
 * User: marcus
 * Date: 07.02.14
 * Time: 15:07
 */

namespace Loki\CharacterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Class CharacterToAttribute the Link between a certain Attribute and a Character, with its level.
 * @package Loki\CharacterBundle\Entity
 * @ORM\Table("`character_to_attribute`")
 * @ORM\Entity(repositoryClass="Loki\CharacterBundle\Repository\CharacterToAttributeRepository")
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(fields={"character","attribute"}, message="Dieser Character hat dieses Attribut bereits")
 */
class CharacterToAttribute extends AbstractEntity
{

    /**
     * @ORM\ManyToOne(targetEntity="Loki\CharacterBundle\Entity\Character", inversedBy="attributes")
     * @ORM\JoinColumn(name="character_id", referencedColumnName="id")
     */
    protected $character;

    /**
     * @ORM\ManyToOne(targetEntity="Loki\CharacterBundle\Entity\Attribute", inversedBy="characterLink")
     * @ORM\JoinColumn(name="attribute_id", referencedColumnName="id")
     */
    protected $attribute;

    /**
     * @ORM\Column(type="integer")
     */
    protected $level;

    /**
     * @param mixed $attribute
     */
    public function setAttribute($attribute)
    {
        $this->attribute = $attribute;
    }

    /**
     * @return mixed
     */
    public function getAttribute()
    {
        return $this->attribute;
    }

    /**
     * @param mixed $character
     */
    public function setCharacter($character)
    {
        $this->character = $character;
    }

    /**
     * @return mixed
     */
    public function getCharacter()
    {
        return $this->character;
    }

    /**
     * @param mixed $level
     */
    public function setLevel($level)
    {
        $this->level = $level;
    }

    /**
     * @return mixed
     */
    public function getLevel()
    {
        return $this->level;
    }


} 