<?php
/**
 * Created by Marcus "Loki" Jenz 
 * Date: 08.03.14
 * Time: 10:53
 */

namespace Loki\CharacterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class ConnectionInDB for Characters that are in the Database
 * SCs die in der DB sind, haben mehrere Entitaeten hiervon, um Connections zu NSCs herzustellen, die
 * in der DB als echte Chars angelegt sind
 * @package Loki\CharacterBundle\Entity
 * @ORM\Table("`connections_in_db`")
 * @ORM\Entity(repositoryClass="Loki\CharacterBundle\Repository\ConnectionInDBRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class ConnectionInDB extends AbstractEntity
{

    /**
     * Character @var
     * @ORM\ManyToOne(targetEntity="Loki\CharacterBundle\Entity\Character", inversedBy="connectionsInDBTarget")
     * @ORM\JoinColumn(name="target_id", referencedColumnName="id")
     */
    protected $target;

    /**
     * Character @var
     * @ORM\ManyToOne(targetEntity="Loki\CharacterBundle\Entity\Character", inversedBy="connectionsInDB")
     * @ORM\JoinColumn(name="owner_id", referencedColumnName="id")
     */
    protected $character;
    /**
     * integer @var
     * @ORM\Column(type="integer")
     */
    protected $level;

    /**
     * Gibt den Namen der Connection zurück!
     * @return String
     */
    public function getName()
    {
        return $this->target->getName();
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
     * @param mixed $owner
     */
    public function setCharacter($owner)
    {
        $this->character = $owner;
    }

    /**
     * @return mixed
     */
    public function getCharacter()
    {
        return $this->character;
    }



    /**
     * @param mixed $target
     */
    public function setTarget($target)
    {
        $this->target = $target;
    }

    /**
     * @return mixed
     */
    public function getTarget()
    {
        return $this->target;
    }


}