<?php
/**
 * Created by Marcus "Loki" Jenz 
 * Date: 14.04.14
 * Time: 12:34
 */

namespace Loki\CharacterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class MagicalTradition
 * @package Loki\CharacterBundle\Entity
 * @ORM\Entity(repositoryClass="Loki\CharacterBundle\Repository\MagicalTraditionRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class MagicalTradition extends AbstractEntity{


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
     * @var Totem
     * @ORM\OneToMany(targetEntity="Totem", mappedBy="tradition")
     */
    protected $totems;
} 