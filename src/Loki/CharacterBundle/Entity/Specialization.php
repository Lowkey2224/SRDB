<?php
/**
 * Created by Marcus "Loki" Jenz 
 * Date: 09.03.14
 * Time: 18:32
 */

namespace Loki\CharacterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Chars
 *
 * @ORM\Table("`specializations`")
 * @ORM\Entity(repositoryClass="Loki\CharacterBundle\Repository\SpecializationRepository")
 * @UniqueEntity(fields={"skill","name"}, message="Diese Spezialisierung existiert bereits.")
 * @ORM\HasLifecycleCallbacks()
 */
class Specialization extends AbstractEntity{

    /**
     * @ORM\ManyToOne(targetEntity="Loki\CharacterBundle\Entity\Skill", inversedBy="specializations")
     * @ORM\JoinColumn(name="skill_id", referencedColumnName="id")
     */
    protected $skill;

    /**
     * @var
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @ORM\OneToMany(targetEntity="Loki\CharacterBundle\Entity\CharacterSkillToSpecialization", mappedBy="spec")
     */
    protected $specializations;
    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
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