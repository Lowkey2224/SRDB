<?php

namespace Loki\CharacterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Attribute
 *
 * @ORM\Table("`attributes`")
 * @ORM\Entity(repositoryClass="Loki\CharacterBundle\Repository\AttributeRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Attribute
{
    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(name="name", type="string", length=45)
     */
    protected $name;

    /**
     * @ORM\OneToMany(targetEntity="Loki\CharacterBundle\Entity\CharacterToAttribute", mappedBy="attribute")
     */
    protected $characterLink;

    /**
     * @ORM\OneToMany(targetEntity="Loki\CharacterBundle\Entity\Skill", mappedBy="attribute")
     */
    protected $skills;

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
     * @return mixed
     */
    public function getSkills()
    {
        return $this->skills;
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
     * @param mixed $skills
     */
    public function setSkills($skills)
    {
        $this->skills = $skills;
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
