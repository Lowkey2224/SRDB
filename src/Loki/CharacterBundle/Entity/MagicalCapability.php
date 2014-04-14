<?php
/**
 * Created by Marcus "Loki" Jenz 
 * Date: 14.04.14
 * Time: 13:01
 */

namespace Loki\CharacterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * Class MagicalKind
 * @package Loki\CharacterBundle\Entity
 * @ORM\Entity(repositoryClass="Loki\CharacterBundle\Repository\MagicalCapabilityRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class MagicalCapability extends AbstractEntity{

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $name;

} 