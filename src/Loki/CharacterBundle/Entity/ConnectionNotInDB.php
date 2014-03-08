<?php
/**
 * Created by JetBrains PhpStorm.
 * User: marcus
 * Date: 22.07.13
 * Time: 10:47
 * To change this template use File | Settings | File Templates.
 */

namespace Loki\CharacterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class ConnectionNotInDB for Characters that are not in the Database
 * SCs die in der DB sind, haben mehrere Entitaeten hiervon, um Connections zu NSCs herzustellen, die nicht
 * in der DB als echte Chars angelegt sind
 * @package Loki\CharacterBundle\Entity
 * @ORM\Table("`connections_not_in_db`")
 * @ORM\Entity(repositoryClass="Loki\CharacterBundle\Repository\ConnectionNotInDBRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class ConnectionNotInDB extends AbstractEntity{





    /**
     * @ORM\Column(type="string")
     */
    protected $target;

    /**
     * Character @var
     * @ORM\ManyToOne(targetEntity="Loki\CharacterBundle\Entity\Character", inversedBy="connectionsNotInDB")
     * @ORM\JoinColumn(name="owner_id", referencedColumnName="id")
     */
    protected $owner;
    /**
     * integer @var
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
     * @param mixed $owner
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;
    }

    /**
     * @return mixed
     */
    public function getOwner()
    {
        return $this->owner;
    }



    /**
     * @param mixed $name
     */
    public function setTarget($name)
    {
        $this->target = $name;
    }

    /**
     * @return mixed
     */
    public function getTarget()
    {
        return $this->target;
    }



}