<?php
/**
 * Created by Marcus "Loki" Jenz 
 * Date: 14.04.14
 * Time: 12:50
 */

namespace Loki\CharacterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Totem
 * @package Loki\CharacterBundle\Entity
 * @ORM\Entity(repositoryClass="Loki\CharacterBundle\Repository\TotemRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Totem extends AbstractEntity{

    /**
     * @var MagicalTradition
     * @ORM\ManyToOne(targetEntity="MagicalTradition", inversedBy="totems")
     * @ORM\JoinColumn(name="tradition_id", referencedColumnName="id")
     */
    protected $tradition;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @var string
     * @ORM\Column(type="text")
     */
    protected $description;

    /**
     * @var string
     * @ORM\Column(type="text")
     */
    protected $ruleText;

} 