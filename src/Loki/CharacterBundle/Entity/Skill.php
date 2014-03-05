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
class Skill
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

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
     * @ORM\Column(type="datetime")
     */
    protected $updated;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $created;

    public function __construct()
    {
        $this->setCreated(new \DateTime());
        $this->setUpdated(new \DateTime());
    }

    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedValue()
    {
        $this->setUpdated(new \DateTime());
    }

    /**
     * @return mixed
     */
    public function getAttribute()
    {
        return $this->attribute;
    }

    /**
     * @return mixed
     */
    public function getCharacterLink()
    {
        return $this->characterLink;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return mixed
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @return mixed
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * @param mixed $attribute
     */
    public function setAttribute($attribute)
    {
        $this->attribute = $attribute;
    }

    /**
     * @param mixed $characterLink
     */
    public function setCharacterLink($characterLink)
    {
        $this->characterLink = $characterLink;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param int $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @param mixed $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * @param mixed $updated
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    }



}
