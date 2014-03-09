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
class CharacterToSkill extends AbstractEntity {

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
     * @ORM\OneToMany(targetEntity="Loki\CharacterBundle\Entity\CharacterSkillToSpecialization", mappedBy="skill")
     */
    protected $specializations;

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

    /**
     * @param mixed $skill
     */
    public function setSkill($skill)
    {
        $this->skill = $skill;
    }

    /**
     * @return mixed
     */
    public function getSkill()
    {
        return $this->skill;
    }

    /**
     * @param mixed $specializations
     */
    public function setSpecializations($specializations)
    {
        $this->specializations = $specializations;
    }

    /**
     * @return mixed
     */
    public function getSpecializations()
    {
        return $this->specializations;
    }


} 