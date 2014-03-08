<?php

namespace Loki\CharacterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Skill
 *
 * @ORM\Table("`skills`")
 * @ORM\Entity(repositoryClass="Loki\CharacterBundle\Repository\SkillRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Skill extends AbstractEntity
{

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=45)
     */
    protected $name;

    /**
     * @var integer
     * 1 = Aktionsskill, 2 = Wissenskill, 3 = Sprachen
     * @ORM\Column(name="type", type="integer")
     */
    protected $type;

    /**
     * @ORM\ManyToOne(targetEntity="Loki\CharacterBundle\Entity\Attribute", inversedBy="skills")
     * @ORM\JoinColumn(name="skill_id", referencedColumnName="id")
     */
    protected $attribute;

    /**
     * @ORM\OneToMany(targetEntity="Loki\CharacterBundle\Entity\Skill", mappedBy="skill")
     */
    protected $characterLink;

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
     * @param mixed $characterLink
     */
    public function setCharacterLink($characterLink)
    {
        $this->characterLink = $characterLink;
    }

    /**
     * @return mixed
     */
    public function getCharacterLink()
    {
        return $this->characterLink;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param int $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }


}
