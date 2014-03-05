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
 *
 * @ORM\Table("`character_to_skill`")
 * @ORM\Entity(repositoryClass="Loki\CharacterBundle\Repository\CharacterToSkillRepository")
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(fields={"character","skill"}, message="Dieser Character hat diese Fähigkeit bereits")
 */
class CharacterToSkill {

    /**
     * @var integer
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Loki\CharacterBundle\Entity\Character", inversedBy="skills")
     * @ORM\JoinColumn(name="character_id", referencedColumnName="id")
     */
    protected $character;

    /**
     * @ORM\ManyToOne(targetEntity="Loki\CharacterBundle\Entity\Skill", inversedBy="characterLink")
     * @ORM\JoinColumn(name="skill_id", referencedColumnName="id")
     */
    protected $skill;

    /**
     * @ORM\Column(type="integer")
     */
    protected $level;

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
    public function getCharacter()
    {
        return $this->character;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @return mixed
     */
    public function getSkill()
    {
        return $this->skill;
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
     * @param mixed $character
     */
    public function setCharacter($character)
    {
        $this->character = $character;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param mixed $level
     */
    public function setLevel($level)
    {
        $this->level = $level;
    }

    /**
     * @param mixed $skill
     */
    public function setSkill($skill)
    {
        $this->skill = $skill;
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