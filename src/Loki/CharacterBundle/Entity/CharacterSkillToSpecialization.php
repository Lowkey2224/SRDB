<?php
/**
 * Created by Marcus "Loki" Jenz 
 * Date: 09.03.14
 * Time: 20:32
 */

namespace Loki\CharacterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Class CharacterToAttribute the Link between a certain CharacterToSkill and a Specialisation, with its level.
 * @package Loki\CharacterBundle\Entity
 *
 * @ORM\Table("`characterskill_to_specialization`")
 * @ORM\Entity(repositoryClass="Loki\CharacterBundle\Repository\CharacterSkillToSpecializationRepository")
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(fields={"spec","skill"}, message="Dieser Character hat diese Spezialisierung bereits")
 */
class CharacterSkillToSpecialization extends AbstractEntity{

    /**
     * @ORM\ManyToOne(targetEntity="Loki\CharacterBundle\Entity\CharacterToSkill", inversedBy="specializations")
     * @ORM\JoinColumn(name="charskill_id", referencedColumnName="id")
     */
    protected $skill;

    /**
     * @ORM\ManyToOne(targetEntity="Loki\CharacterBundle\Entity\Specialization", inversedBy="specializations")
     * @ORM\JoinColumn(name="charskill_id", referencedColumnName="id")
     */
    protected $spec;

    /**
     * @ORM\Column(type="integer")
     */
    protected $level;

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
     * @param mixed $spec
     */
    public function setSpec($spec)
    {
        $this->spec = $spec;
    }

    /**
     * @return mixed
     */
    public function getSpec()
    {
        return $this->spec;
    }



} 