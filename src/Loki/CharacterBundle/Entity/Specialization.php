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

} 