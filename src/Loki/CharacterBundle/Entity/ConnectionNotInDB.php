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
class ConnectionNotInDB {

    /**
     * @var integer
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Loki\CharacterBundle\Entity\Character", inversedBy="connectionsNotInDB")
     * @ORM\JoinColumn(name="character_id", referencedColumnName="id")
     */
    protected $character;
    /**
     * @ORM\Column(type="integer")
     */
    protected $level;

    /**
     * @ORM\Column(type="string")
     */
    protected $name;

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
     * @return mixed
     */
    public function getCreated()
    {
        return $this->created;
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
    public function getName()
    {
        return $this->name;
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
     * @param mixed $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
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
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param mixed $updated
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    }



}