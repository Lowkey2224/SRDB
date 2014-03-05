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
 * Class EquipItem
 * @package Loki\CharacterBundle\Entity
 * @ORM\Table("`equip_items`")
 * @ORM\Entity(repositoryClass="Loki\CharacterBundle\Repository\EquipItemRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class EquipItem {

    /**
     * @var integer
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Loki\CharacterBundle\Entity\Character", inversedBy="items")
     * @ORM\JoinColumn(name="character_id", referencedColumnName="id")
     */
    protected $character;

    /**
     * @ORM\Column(type="integer")
     */
    protected $amount;

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
    public function getAmount()
    {
        return $this->amount;
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
    public function getUpdated()
    {
        return $this->updated;
    }



    /**
     * @param mixed $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
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
     * @param mixed $updated
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    }


}